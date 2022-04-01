<?php

namespace App\Rest\DTO;

use App\Enum\EventNameDTOEnum;
use App\Exception\NotImplementedException;
use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Interfaces\InterceptorInterface;
use App\Rest\Http\Request;
use Codememory\Support\Str;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class AbstractDTO
 *
 * @package App\Rest\DTO
 *
 * @author  Codememory
 */
abstract class AbstractDTO implements DTOInterface
{

	/**
	 * @var Request|null
	 */
	public readonly ?Request $request;

	/**
	 * @var ManagerRegistry|null
	 */
	public readonly ?ManagerRegistry $managerRegistry;

	/**
	 * @var EntityManagerInterface|null
	 */
	public readonly ?EntityManagerInterface $em;

	/**
	 * @var InterceptorInterface[]
	 */
	private array $interceptors = [];

	/**
	 * @var array
	 */
	private array $expectedRequestKeys = [];

	/**
	 * @var array
	 */
	private array $aliasesExpectedRequestKeys = [];

	/**
	 * @var array
	 */
	private array $excludesKeysForBuildEntity = [];

	/**
	 * @var array
	 */
	private array $valuesByExpectedKeys = [];

	/**
	 * @var array
	 */
	private array $events = [];

	/**
	 * @var string|null
	 */
	private ?string $entity = null;

	/**
	 * @var EntityInterface|null
	 */
	private ?EntityInterface $collectedEntity = null;

	/**
	 * @param Request|null         $request
	 * @param ManagerRegistry|null $managerRegistry
	 */
	final public function __construct(?Request $request = null, ?ManagerRegistry $managerRegistry = null)
	{

		$this->request = $request;
		$this->managerRegistry = $managerRegistry;
		$this->em = $managerRegistry?->getManager();

		if (null !== $request) {
			$this->wrapper();
			$this->initValuesByExpectedKeys();
			$this->callSetters();
			$this->buildEntity();
		}

	}

	/**
	 * @return void
	 */
	protected function wrapper(): void {}

	/**
	 * @return void
	 */
	private function initValuesByExpectedKeys(): void
	{

		$this->callEventListeners(EventNameDTOEnum::BEFORE_INIT_REQUEST_VALUES);

		foreach ($this->expectedRequestKeys as $expectedRequestKey) {
			$requestValue = $this->request->get($expectedRequestKey);

			if (array_key_exists($expectedRequestKey, $this->interceptors)) {
				$interceptor = $this->interceptors[$expectedRequestKey];

				$this->valuesByExpectedKeys[$expectedRequestKey] = $interceptor->process($expectedRequestKey, $requestValue);
			} else {
				$this->valuesByExpectedKeys[$expectedRequestKey] = $requestValue;
			}
		}

		$this->callEventListeners(
			EventNameDTOEnum::AFTER_INIT_REQUEST_VALUES,
			$this->valuesByExpectedKeys
		);
	}

	/**
	 * @param EventNameDTOEnum $eventNameDTOEnum
	 * @param mixed            ...$args
	 *
	 * @return void
	 */
	private function callEventListeners(EventNameDTOEnum $eventNameDTOEnum, mixed ...$args): void
	{

		foreach ($this->events[$eventNameDTOEnum->value] ?? [] as $event) {
			call_user_func($event, ...$args);
		}

	}

	/**
	 * @return void
	 */
	private function callSetters(): void
	{

		foreach ($this->valuesByExpectedKeys as $key => $value) {
			$key = $this->getAutoNameExpectedRequestKey($key);

			$this->{$key} = $value;
		}

		$this->callEventListeners(EventNameDTOEnum::AFTER_SETTER, $this);

	}

	/**
	 * @param string $default
	 *
	 * @return string
	 */
	private function getAutoNameExpectedRequestKey(string $default): string
	{

		if (null !== $this->aliasesExpectedRequestKeys[$default]) {
			$default = $this->aliasesExpectedRequestKeys[$default];
		}

		return $default;

	}

	/**
	 * @return void
	 */
	private function buildEntity(): void
	{

		if (null !== $this->entity) {
			$this->callEventListeners(EventNameDTOEnum::BEFORE_BUILD_ENTITY);

			$entityNamespace = $this->entity;
			$entity = new $entityNamespace();

			foreach ($this->valuesByExpectedKeys as $key => $value) {
				$key = $this->getAutoNameExpectedRequestKey($key);

				if (!in_array($key, $this->excludesKeysForBuildEntity)) {
					$entity->{$this->generateSetterName($key)}($value);
				}
			}

			$this->collectedEntity = $entity;

			$this->callEventListeners(
				EventNameDTOEnum::AFTER_BUILD_ENTITY,
				$this->collectedEntity
			);
		}

	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	private function generateSetterName(string $name): string
	{

		return sprintf('set%s', ucfirst(Str::camelCase($name)));

	}

	/**
	 * @param string $requestKey
	 * @param string $interceptorNamespace
	 *
	 * @return AbstractDTO
	 * @throws ClassNotFoundException
	 * @throws ReflectionException
	 */
	protected function addInterceptor(string $requestKey, string $interceptorNamespace): self
	{

		if (!class_exists($interceptorNamespace)) {
			throw new ClassNotFoundException($interceptorNamespace);
		}

		$reflection = new ReflectionClass($interceptorNamespace);

		if (!$reflection->implementsInterface(InterceptorInterface::class)) {
			throw new NotImplementedException($interceptorNamespace, InterceptorInterface::class);
		}

		$this->interceptors[$requestKey] = $reflection->newInstance($this);

		return $this;

	}

	/**
	 * @param string      $key
	 * @param string|null $alias
	 *
	 * @return AbstractDTO
	 */
	protected function addExpectedRequestKey(string $key, ?string $alias = null): self
	{

		$this->expectedRequestKeys[] = $key;
		$this->aliasesExpectedRequestKeys[$key] = $alias;

		return $this;

	}

	/**
	 * @param string $namespace
	 *
	 * @return $this
	 */
	protected function setEntity(string $namespace): self
	{

		$this->entity = $namespace;

		return $this;

	}

	/**
	 * @param callable $handler
	 *
	 * @return $this
	 */
	protected function changeEntity(callable $handler): self
	{

		$this->addEventListener(EventNameDTOEnum::AFTER_BUILD_ENTITY, $handler);

		return $this;

	}

	/**
	 * @param EventNameDTOEnum $eventTypeDTOEnum
	 * @param callable         $handler
	 *
	 * @return $this
	 */
	protected function addEventListener(EventNameDTOEnum $eventTypeDTOEnum, callable $handler): self
	{

		$this->events[$eventTypeDTOEnum->value][] = $handler;

		return $this;

	}

	/**
	 * @param string $key
	 *
	 * @return $this
	 */
	protected function excludeRequestKeyForBuildEntity(string $key): self
	{

		$this->excludesKeysForBuildEntity[] = $key;

		return $this;

	}

	/**
	 * @param array $data
	 * @param array $excludeKeys
	 *
	 * @return array
	 */
	protected function toArrayHandler(array $data, array $excludeKeys = []): array
	{

		foreach ($excludeKeys as $excludeKey) {
			unset($data[$excludeKey]);
		}

		return $data;

	}

	/**
	 * @inheritDoc
	 */
	public function updateEntity(EntityInterface $entity): DTOInterface
	{

		$this->collectedEntity = $entity;

		return $this;

	}

	/**
	 * @inheritDoc
	 */
	public function transform(array $entities, array $excludeKeys = []): array
	{

		$data = [];

		foreach ($entities as $entity) {
			$data[] = $this->toArray($entity, $excludeKeys);
		}

		return $data;

	}

	/**
	 * @inheritDoc
	 */
	public function toArray(EntityInterface $entity, array $excludeKeys = []): array
	{

		return [];

	}

	/**
	 * @inheritDoc
	 */
	public function getCollectedEntity(): ?EntityInterface
	{

		return $this->collectedEntity;

	}

}