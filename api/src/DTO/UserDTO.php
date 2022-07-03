<?php

namespace App\DTO;

use App\Entity\User;

/**
 * Class UserDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<User>
 *
 * @author  Codememory
 */
class UserDTO extends AbstractDTO
{
    public ?string $ip = null;

    protected function wrapper(): void
    {
        $this->ip = $this->request->request?->getClientIp();
    }
}