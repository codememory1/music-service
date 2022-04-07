<?php

namespace App\Traits\DTO;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait PasswordConfirmTrait.
 *
 * @package App\Traits\DTO
 *
 * @author  Codememory
 */
trait PasswordConfirmTrait
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@passwordConfirmIsRequired')]
    #[AppAssert\Between('password', message: 'user@invalidPasswordConfirm')]
    public ?string $passwordConfirm = null;
}