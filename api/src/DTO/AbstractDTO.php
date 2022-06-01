<?php

namespace App\DTO;

use App\DTO\Interfaces\DTOInterface;
use App\DTO\Interfaces\ValueInterceptorInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use App\Security\Auth\AuthorizedUser;
use function call_user_func;
use function is_callable;
use function is_string;

/**
 * Class AbstractDTO.
 *
 * @package App\DTO
 * @template Entity as mixed
 *
 * @author  Codememory
 */
abstract class AbstractDTO implements DTOInterface
{
    /**
     * @var null|EntityInterface|string
     */
    protected EntityInterface|string|null $entity = null;

    /**
     * @var array
     */
    protected array $expectKeys = [];

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var string
     */
    protected string $requestType;
    protected readonly AuthorizedUser $authorizedUser;

    /**
     * @var array
     */
    private array $forbiddenKeysForSetters = [];

    /**
     * @var SetterCallRuleInEntity
     */
    private SetterCallRuleInEntity $setterCallRuleInEntity;

    /**
     * @var array
     */
    private array $setterCallRulesInEntity = [];

    /**
     * @var array<ValueInterceptorInterface>
     */
    private array $valueInterceptors = [];

    /**
     * @param Request                $request
     * @param SetterCallRuleInEntity $setterCallRuleInEntity
     * @param AuthorizedUser         $authorizedUser
     */
    public function __construct(Request $request, SetterCallRuleInEntity $setterCallRuleInEntity, AuthorizedUser $authorizedUser)
    {
        $this->request = $request;
        $this->setterCallRuleInEntity = $setterCallRuleInEntity;
        $this->requestType = $request->request->attributes->get('request_type');
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @return void
     */
    abstract protected function wrapper(): void;

    /**
     * @param string      $fieldName
     * @param null|string $as
     *
     * @return $this
     */
    final protected function addExpectKey(string $fieldName, ?string $as = null): self
    {
        $this->expectKeys[] = [
            'name' => $fieldName,
            'alias' => $as
        ];

        return $this;
    }

    /**
     * @param string $requestTypePattern
     * @param string $propertyName
     *
     * @return SetterCallRuleInEntity
     */
    final protected function callSetterToEntityWhenRequest(string $requestTypePattern, string $propertyName): SetterCallRuleInEntity
    {
        $setterCallRuleInEntity = clone $this->setterCallRuleInEntity;

        $this->setterCallRulesInEntity[$propertyName] = [
            'type_pattern' => $requestTypePattern,
            'rules' => $setterCallRuleInEntity
        ];

        return $setterCallRuleInEntity;
    }

    /**
     * @param string                             $propertyName
     * @param callable|ValueInterceptorInterface $interceptor
     *
     * @return $this
     */
    final protected function addInterceptor(string $propertyName, ValueInterceptorInterface|callable $interceptor): self
    {
        $this->valueInterceptors[$propertyName] = $interceptor;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRequestType(string $type): self
    {
        $this->requestType = $type;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function preventSetterCallForKeys(array $propertyNames): self
    {
        $this->forbiddenKeysForSetters = $propertyNames;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function collect(): self
    {
        $this->wrapper();
        $this->createEntityObject();
        $this->expectedKeyHandler();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @return Entity
     */
    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    /**
     * @return void
     */
    private function createEntityObject(): void
    {
        if (is_string($this->entity)) {
            $this->entity = new ($this->entity)();
        }
    }

    /**
     * @return void
     */
    private function expectedKeyHandler(): void
    {
        $allInputs = $this->request->all();
        $allInputs = array_merge($allInputs, $this->request->request->query->all());

        foreach ($this->expectKeys as $expectKey) {
            $propertyName = $expectKey['alias'] ?: $expectKey['name'];
            $expectedKeyInterceptor = $this->valueInterceptors[$propertyName] ?? null;
            $expectedKeyValue = $allInputs[$expectKey['name']] ?? null;

            if (null !== $expectedKeyInterceptor) {
                if (is_callable($expectedKeyInterceptor)) {
                    $expectedKeyValue = call_user_func($expectedKeyInterceptor, $expectKey['name'], $expectedKeyValue);
                } else {
                    $expectedKeyValue = $expectedKeyInterceptor->handle($expectKey['name'], $expectedKeyValue);
                }
            }

            $this->{$propertyName} = $expectedKeyValue;

            if (null !== $this->entity) {
                $this->setterCallInEntityHandler($propertyName);
            }
        }
    }

    /**
     * @param string $propertyName
     *
     * @return void
     */
    private function setterCallInEntityHandler(string $propertyName): void
    {
        $setterName = $this->generateSetterName($propertyName);
        $ruleForSetter = $this->setterCallRulesInEntity[$propertyName] ?? null;

        if (false === in_array($propertyName, $this->forbiddenKeysForSetters, true)) {
            if (null !== $ruleForSetter) {
                if (1 === preg_match("/{$ruleForSetter['type_pattern']}/", $this->requestType)
                    && true === $ruleForSetter['rules']->isPassed()) {
                    $this->entity->$setterName($this->{$propertyName});
                }
            } else {
                $this->entity->$setterName($this->{$propertyName});
            }
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function generateSetterName(string $key): string
    {
        return sprintf('set%s', ucfirst($key));
    }
}