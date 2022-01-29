<?php

namespace App\Service\Response;

use App\Enums\ApiResponseTypeEnum;

/**
 * Class ApiResponseSchema
 *
 * @package App\Service\Response
 *
 * @author  Codememory
 */
class ApiResponseSchema
{

    /**
     * @var array
     */
    private array $schema = [
        'status'      => null,
        'status_code' => null,
        'message'     => [],
        'data'        => []
    ];

    /**
     * @param string $status
     * @param int    $code
     */
    public function __construct(string $status, int $code)
    {

        $this->schema['status'] = $status;
        $this->schema['status_code'] = $code;

    }

    /**
     * @param ApiResponseTypeEnum $type
     * @param string              $name
     * @param string|null         $text
     *
     * @return $this
     */
    public function setMessage(ApiResponseTypeEnum $type, string $name, ?string $text): ApiResponseSchema
    {

        $this->schema['message']['type'] = $type->value;
        $this->schema['message']['name'] = $name;
        $this->schema['message']['text'] = $text ?? '';

        return $this;

    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data): ApiResponseSchema
    {

        $this->schema['data'] = $data;

        return $this;

    }

    /**
     * @return array
     */
    public function getSchema(): array
    {

        return $this->schema;

    }

}