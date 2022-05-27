<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PasswordReset;
use App\Entity\User;
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
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = PasswordReset::class;

    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    public ?User $user = null;

    #[Required]
    private ?EntityManagerInterface $em = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('email', 'user');

        $this->addInterceptor('user', new AsEntityInterceptor($this->em, User::class, 'email'));
    }
}