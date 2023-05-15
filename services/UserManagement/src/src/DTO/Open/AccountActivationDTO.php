<?php

namespace App\DTO\Open;

use App\Entity\User;
use App\Exceptions\EntityNotFoundException;
use Codememory\Dto\DataTransfer;
use Codememory\Dto\Constraints as DC;
use Symfony\Component\Validator\Constraints as Assert;

final class AccountActivationDTO extends DataTransfer
{
    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.email')
    ])]
    #[DC\ToEntity(byKey: 'email', entityNotFoundCallback: 'throwUserNotFound')]
    public ?User $email = null;

    #[DC\Validation([
        new Assert\NotBlank(message: 'field.is_required.code'),
        new Assert\Length(
            min: 6,
            max: 6,
            exactMessage: 'field.length.exact.account_activation_code',
        ),
        new Assert\Regex('/^[0-9]+$/', 'field.regexp.account_activation_code')
    ])]
    public ?string $code = null;

    /**
     * @throws EntityNotFoundException
     */
    public function throwUserNotFound(): void
    {
        throw EntityNotFoundException::userByEmailNotFound();
    }
}