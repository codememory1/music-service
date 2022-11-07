<?php

namespace App\Rest\Validator\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;

interface ValidatorInterface
{
    public function validate(DataTransferInterface|EntityInterface $object, ?callable $customResponse = null, array $groups = []): void;
}