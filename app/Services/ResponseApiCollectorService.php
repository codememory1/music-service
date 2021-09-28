<?php

namespace App\Services;

/**
 * Class ResponseApiCollectorService
 *
 * @package App\Services
 *
 * @author  Codememory
 */
class ResponseApiCollectorService
{

    /**
     * @var array
     */
    private array $responseData = [
        'status'   => 200,
        'type'     => null,
        'response' => [
            'messages' => [],
            'data'     => []
        ]
    ];

    /**
     * @param int   $status
     * @param array $messages
     * @param array $data
     *
     * @return $this
     */
    public function create(int $status, array $messages = [], array $data = []): ResponseApiCollectorService
    {

        $this->responseData['status'] = $status;
        $this->responseData['response']['messages'] = $messages;
        $this->responseData['response']['data'] = $data;

        return $this;

    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): ResponseApiCollectorService
    {

        $this->responseData['type'] = $type;

        return $this;

    }

    /**
     * @return int
     */
    public function getStatus(): int
    {

        return $this->responseData['status'];

    }

    /**
     * @return array
     */
    public function getResponse(): array
    {

        return $this->responseData['response'];

    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {

        return $this->responseData['type'];

    }

}