<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccessTokenDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AccessTokenDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'common@refreshTokenIsRequired')]
    public ?string $refreshToken = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->refreshToken = $this->request->request->cookies->get('refresh_token');
    }
}