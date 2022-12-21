<?php

namespace App\Rest\Response\Http;

use App\Rest\Response\AbstractHttpResponseCollector;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Rest\Response\Interfaces\ResponseMetaInterface;
use App\Rest\Response\Interfaces\SuccessHttpResponseCollectorInterface;

final class SuccessHttpResponseCollector extends AbstractHttpResponseCollector implements SuccessHttpResponseCollectorInterface
{
    private array $response = [];
    private array $data = [];
    private array $meta = [];

    public function collect(): HttpResponseCollectorInterface
    {
        $this->response = [
            'http_code' => $this->getHttpCode(),
            'platform_code' => $this->getPlatformCode()->value,
            'data' => $this->data
        ];

        if ([] !== $this->meta) {
            $this->response['meta'] = $this->meta;
        }

        return $this;
    }

    public function getCollectedResponse(): array
    {
        return $this->response;
    }

    public function setData(array $data): SuccessHttpResponseCollectorInterface
    {
        $this->data = $data;

        return $this;
    }

    public function addMeta(ResponseMetaInterface $meta): SuccessHttpResponseCollectorInterface
    {
        $this->meta[$meta->getKey()] = $meta->getMeta();

        return $this;
    }
}