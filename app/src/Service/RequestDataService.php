<?php

namespace App\Service;

/**
 * Class RequestDataService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class RequestDataService
{

    /**
     * @var array
     */
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {

        $this->data = $data;

    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = ''): mixed
    {

        $value = $this->data[$key] ?? null;

        return $value ?? $default;

    }

}