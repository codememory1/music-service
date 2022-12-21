<?php

namespace App\Rest\Response\Interfaces;

interface SuccessHttpResponseCollectorInterface extends HttpResponseCollectorInterface
{
    public function setData(array $data): self;

    public function addMeta(ResponseMetaInterface $meta): self;
}