<?php

namespace App\Rest\Response\Interfaces;

interface ResponseCreatorInterface
{
    public function response(ResponseCollectorInterface $collector): mixed;
}