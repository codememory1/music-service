<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\DTO\Traits\SetPasswordTrait;
use App\Entity\User;
use App\Enum\UserStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class RestorePasswordDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class RestorePasswordDTO extends AbstractDTO
{
    use SetPasswordTrait;

    #[Assert\NotBlank(message: 'common@invalidCode')]
    public ?string $code = null;

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    public ?User $user = null;

    #[Required]
    public ?EntityManagerInterface $em = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('email', 'user');
        $this->addExpectKey('code');
        $this->addExpectKey('password');
        $this->addExpectKey('password_confirm', 'passwordConfirm');

        $this->addInterceptor('user', new AsEntityInterceptor(
            $this->em,
            User::class,
            'email',
            ['status' => UserStatusEnum::ACTIVE->name]
        ));
    }
}