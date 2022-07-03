<?php

namespace App\DTO;

use App\DTO\Interfaces\DTOInterface;
use App\DTO\Interfaces\ValueInterceptorInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use App\Security\AuthorizedUser;
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
    protected EntityInterface|string|null $entity = null;
    protected array $expectKeys = [];
    protected Request $request;
    protected ?string $requestType;
    protected readonly AuthorizedUser $authorizedUser;
    private array $forbiddenKeysForSetters = [];
    private SetterCallRuleInEntity $setterCallRuleInEntity;
    private array $setterCallRulesInEntity = [];
    private array $valueInterceptors = [];

    public function __construct(Request $request, SetterCallRuleInEntity $setterCallRuleInEntity, AuthorizedUser $authorizedUser)
    {
        $this->request = $request;
        $this->setterCallRuleInEntity = $setterCallRuleInEntity;
        $this->requestType = $request->request?->attributes->get('request_type');
        $this->authorizedUser = $authorizedUser;
    }

    abstract protected function wrapper(): void;

    final protected function addExpectKey(string $fieldName, ?string $as = null): self
    {
        $this->expectKeys[] = [
            'name' => $fieldName,
            'alias' => $as
        ];

        return $this;
    }

    final protected function callSetterToEntityWhenRequest(string $requestTypePattern, string $propertyName): SetterCallRuleInEntity
    {
        $setterCallRuleInEntity = clone $this->setterCallRuleInEntity;

        $this->setterCallRulesInEntity[$propertyName] = [
            'type_pattern' => $requestTypePattern,
            'rules' => $setterCallRuleInEntity
        ];

        return $setterCallRuleInEntity;
    }

    final protected function addInterceptor(string $propertyName, ValueInterceptorInterface|callable $interceptor): self
    {
        $this->valueInterceptors[$propertyName] = $interceptor;

        return $this;
    }

    public function setRequestType(string $type): self
    {
        $this->requestType = $type;

        return $this;
    }

    public function preventSetterCallForKeys(array $propertyNames): self
    {
        $this->forbiddenKeysForSetters = $propertyNames;

        return $this;
    }

    public function collect(): self
    {
        $this->wrapper();
        $this->createEntityObject();
        $this->expectedKeyHandler();

        return $this;
    }

    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return Entity
     */
    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    private function createEntityObject(): void
    {
        if (is_string($this->entity)) {
            $this->entity = new ($this->entity)();
        }
    }

    private function expectedKeyHandler(): void
    {
        foreach ($this->expectKeys as $expectKey) {
            $propertyName = $expectKey['alias'] ?: $expectKey['name'];
            $expectedKeyInterceptor = $this->valueInterceptors[$propertyName] ?? null;
            $expectedKeyValue = $this->request->get($expectKey['name']);

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

    private function generateSetterName(string $key): string
    {
        return sprintf('set%s', ucfirst($key));
    }
}