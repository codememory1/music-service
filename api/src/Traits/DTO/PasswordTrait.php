<?php

namespace App\Traits\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait PasswordTrait.
 *
 * @package App\Traits\DTO
 *
 * @author  Codememory
 */
trait PasswordTrait
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@passwordIsRequired')]
    #[Assert\Length(min: 8, minMessage: 'user@passwordMinLength')]
    #[Assert\Regex('/^[a-z0-9\-_%\.\$\#]+$/i', message: 'user@passwordRegex')]
    public ?string $password = null;
}