<?php

namespace App\Rest\Validator;

use function is_array;
use LogicException;

/**
 * Class GroupExpressionLanguage.
 *
 * @package App\Rest\Validator
 *
 * @example key: value
 *          key: [value_1, value_2]
 *          key: value, key_2: [value1, value_2], key_3: value
 *
 * @author  Codememory
 */
class GroupExpressionLanguage
{
    /**
     * @var array
     */
    private array $expressions = [];

    /**
     * @var null|int
     */
    private ?int $indexOfLastGroup = null;

    /**
     * @return $this
     */
    public function createGroup(): self
    {
        $this->indexOfLastGroup = count($this->expressions) + 1;

        return $this;
    }

    /**
     * @param string           $key
     * @param array|int|string $value
     *
     * @return $this
     */
    public function addExpr(string $key, string|int|array $value): self
    {
        if (null === $this->indexOfLastGroup) {
            throw new LogicException('Expression group not created');
        }

        if (is_array($value)) {
            $value = sprintf('[%s]', implode(', ', $value));
        }

        $this->expressions[$this->indexOfLastGroup][] = "${key}: ${value}";

        return $this;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        $groups = [];

        foreach ($this->expressions as $groupExpressions) {
            $groups[] = implode(', ', $groupExpressions);
        }

        return $groups;
    }

    /**
     * @return null|int
     */
    public function getIndexOfLastGroup(): ?int
    {
        return $this->indexOfLastGroup;
    }
}