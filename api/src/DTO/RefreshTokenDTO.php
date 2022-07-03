<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RefreshTokenDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RefreshTokenDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'common@refreshTokenIsRequired')]
    public ?string $refreshToken = null;

    protected function wrapper(): void
    {
        $this->refreshToken = $this->request->request->cookies->get('refresh_token');
    }
}