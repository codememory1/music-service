<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Enum\UserStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class RequestRestorationPasswordDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<PasswordReset>
 *
 * @author  Codememory
 */
class RequestRestorationPasswordDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = PasswordReset::class;

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    public ?User $user = null;

    #[Required]
    public ?EntityManagerInterface $em = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('email', 'user');

        $this->addInterceptor('user', new AsEntityInterceptor(
            $this->em,
            User::class,
            'email',
            ['status' => UserStatusEnum::ACTIVE->name]
        ));
    }
}