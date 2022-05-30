<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;

/**
 * Class UserRolePermissionDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class UserRolePermissionDTO extends AbstractDTO
{
    /**
     * @var array
     */
    public array $permissions = [];

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('permissions');

        $this->addInterceptor('permissions', new AsArrayInterceptor());
    }
}