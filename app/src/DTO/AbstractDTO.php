<?php

namespace App\DTO;

use App\Exception\UndefinedClassForDTOException;
use App\Interface\DTOInterface;
use App\Interface\EntityInterface;
use App\Service\RequestDataService;
use Closure;
use Codememory\Support\Str;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AbstractDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
abstract class AbstractDTO implements DTOInterface
{

    /**
     * @var array
     */
    protected array $requestKeys = [];

    /**
     * @var array
     */
    protected array $valueAsEntity = [];

    /**
     * @var array
     */
    protected array $excludeKeysForEntity = [];

    /**
     * @var array
     */
    protected array $excludeKeyForEntity = [];

    /**
     * @var string|null
     */
    protected ?string $entityClass = null;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var ObjectManager|null
     */
    protected ?ObjectManager $em;

    /**
     * @var EntityInterface|null
     */
    protected ?EntityInterface $entity = null;

    /**
     * @var Closure|null
     */
    private ?Closure $afterEntityBuild = null;

    /**
     * @param RequestDataService|null $requestDataService
     * @param ManagerRegistry|null    $managerRegistry
     */
    public function __construct(?RequestDataService $requestDataService = null, ?ManagerRegistry $managerRegistry = null)
    {

        if (null !== $requestDataService) {
            $this->pullRequestKeys($requestDataService);
        }

        $this->em = $managerRegistry?->getManager();

        $this->dataInitializer();

    }

    /**
     * @param array $data
     * @param array $keys
     *
     * @return void
     */
    protected function excludeKeys(array &$data, array $keys): void
    {

        foreach ($data as $key => $value) {
            if (in_array($key, $keys)) {
                unset($data[$key]);
            }
        }

    }

    /**
     * @return EntityInterface
     * @throws UndefinedClassForDTOException
     */
    public function getCollectedEntity(): object
    {

        $entityClass = $this->entityClass;

        if (null === $entityClass) {
            throw new UndefinedClassForDTOException(static::class);
        }

        $entity = $this->entity ?? new $entityClass();

        foreach ($this->data as $key => $value) {
            if (!in_array($key, $this->excludeKeyForEntity)) {
                $setter = sprintf('set%s', ucfirst(Str::camelCase($key)));
                $getter = sprintf('get%s', ucfirst(Str::camelCase($key)));

                if (!in_array($key, $this->excludeKeyForEntity)) {
                    $entity->{$setter}($this->{$getter}());
                }
            }
        }

        $this->entity = $entity;

        if (null !== $this->afterEntityBuild) {
            call_user_func($this->afterEntityBuild, $entity);
        }

        return $entity;

    }

    /**
     * @param callable $handler
     *
     * @return static
     */
    public function afterEntityBuild(callable $handler): static
    {

        $this->afterEntityBuild = $handler;

        return $this;

    }

    /**
     * @param EntityInterface|null $entity
     *
     * @return static
     */
    public function update(?EntityInterface $entity = null): static
    {

        if (null !== $entity) {
            $this->entity = $entity;
        }

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function transform(array $entities, array $exclude = []): array
    {

        $data = [];

        foreach ($entities as $entity) {
            $data[] = static::toArray($entity, $exclude);
        }

        return $data;

    }

    /**
     * @return void
     */
    private function dataInitializer(): void
    {

        foreach ($this->data as $key => $value) {
            $setter = sprintf('set%s', ucfirst(Str::camelCase($key)));

            if (array_key_exists($key, $this->valueAsEntity)) {
                $valueAsEntity = $this->valueAsEntity[$key];

                /** @var ServiceEntityRepository $repository */
                $repository = $this->em->getRepository($valueAsEntity[0]);
                $fined = $repository->findOneBy([$valueAsEntity[1] => $value]);

                $this->{$setter}($fined);
            } else {
                $this->{$setter}($value);
            }
        }

    }

    /**
     * @param RequestDataService $requestDataService
     *
     * @return void
     */
    private function pullRequestKeys(RequestDataService $requestDataService): void
    {

        foreach ($this->requestKeys as $key) {
            $this->data[$key] = $requestDataService->get($key);
        }

    }

}