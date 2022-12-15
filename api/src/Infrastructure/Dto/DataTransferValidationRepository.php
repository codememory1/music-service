<?php

namespace App\Infrastructure\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class DataTransferValidationRepository
{
    private array $inputData = [];
    private array $constraints = [];

    public function addInput(string $key, mixed $value): self
    {
        $this->inputData[$key] = $value;

        return $this;
    }

    public function addConstraints(string $inputName, array $constraints): self
    {
        if (!array_key_exists($inputName, $constraints)) {
            $this->constraints[$inputName] = [];
        }

        $this->constraints[$inputName] = array_merge($this->constraints[$inputName], $constraints);

        return $this;
    }

    public function getInputData(): array
    {
        return $this->inputData;
    }

    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection($this->constraints);
    }
}