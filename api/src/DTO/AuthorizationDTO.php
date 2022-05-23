<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthorizationDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AuthorizationDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'common@incorrectEmail')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'common@passwordIsRequired')]
    public ?string $password = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('email');
        $this->addExpectKey('password');
    }
}