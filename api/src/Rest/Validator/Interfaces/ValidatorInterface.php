<?php

namespace App\Rest\Validator\Interfaces;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;

interface ValidatorInterface
{
    public function validate(DataTransferInterface|EntityInterface $object, ?callable $customResponse = null, array $groups = []): void;
}