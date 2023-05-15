<?php

namespace App\DTO\Open;

use App\Constraints\Assert as AppAssert;
use App\Entity\User;
use Codememory\Dto\Constraints as DC;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<User>
 */
#[DC\XSS]
#[DC\ToType]
final class RegistrationDTO extends DataTransfer
{
    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.email'),
        new Assert\Email(message: 'field.email.invalid'),
        new Assert\Length(max: 300, maxMessage: 'field.length.max.email')
    ])]
    public ?string $email = null;

    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.password'),
        new Assert\Length(min: 8, minMessage: 'field.length.min.password'),
        new Assert\Regex('/^[a-zA-Z0-9!@#$%_-]+$/', 'field.regexp.password')
    ])]
    public ?string $password = null;

    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.password_confirm'),
        new AppAssert\ComparisonBetween(false, 'password', 'field.does_not_match.password')
    ])]
    #[DC\IgnoreSetterCall]
    public ?string $passwordConfirm = null;
}