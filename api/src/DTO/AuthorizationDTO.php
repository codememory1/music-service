<?php

namespace App\DTO;

use App\Interfaces\UserIdentificationInterface;
use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthorizationDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AuthorizationDTO extends AbstractDTO implements UserIdentificationInterface
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@loginIsRequired')]
    public ?string $login = null;

    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@passwordIsRequired')]
    public ?string $password = null;

    /**
     * @var null|string
     */
    public ?string $clientIp = null;

    /**
     * @return void
     */
    protected function wrapper(): void
    {
        $this
            ->addExpectedRequestKey('login')
            ->addExpectedRequestKey('password');

        $this->clientIp = $this->request->request->getClientIp();
    }

    /**
     * @inheritDoc
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }
}