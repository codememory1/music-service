<?php

namespace App\Rest\Response\Interfaces;

interface FailedHttpResponseCollectorInterface extends HttpResponseCollectorInterface
{
    public function getMessage(): string;

    public function setMessage(string $message): self;

    public function getMessageParameters(): array;

    public function setMessageParameters(array $parameters): self;
}