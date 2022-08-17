<?php

namespace App\Exception\Interfaces;

use App\Enum\ResponseTypeEnum;

interface HttpExceptionInterface
{
    public function getStatusCode(): int;

    public function getResponseType(): ResponseTypeEnum;

    public function getMessageTranslationKey(): string;

    public function getParameters(): array;

    public function getData(): array;

    public function getHeaders(): array;
}