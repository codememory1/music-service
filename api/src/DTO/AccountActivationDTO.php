<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AccountActivationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AccountActivationDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'user@failedToIdentify')]
    public ?User $user = null;

    #[Assert\NotBlank(message: 'common@invalidCode')]
    public ?string $code = null;

    #[Required]
    public ?EntityManagerInterface $em = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('email', 'user');
        $this->addExpectKey('code');

        $this->addInterceptor('user', new AsEntityInterceptor($this->em, User::class, 'email'));
    }
}