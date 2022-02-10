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

    /**
     * @var array|string[]
     */
    protected array $requestKeys = [
        'login', 'password'
    ];

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@loginIsRequired', payload: 'login_is_required')]
    private ?string $login = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'user@passwordIsRequired', payload: 'password_is_required')]
    private ?string $password = null;

    /**
     * @var string|null
     */
    private ?string $clientIp = null;

    /**
     * @inheritDoc
     */
    public function transform(array $entities, array $exclude = []): array
    {

        return [];

    }

    /**
     * @param string|null $login
     *
     * @return AuthorizationDTO
     */
    public function setLogin(?string $login): self
    {

        $this->login = $login;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {

        return $this->login;

    }

    /**
     * @param string|null $password
     *
     * @return AuthorizationDTO
     */
    public function setPassword(?string $password): self
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {

        return $this->password;

    }

    public function setClientIp(string $ip): self
    {

        $this->clientIp = $ip;

        return $this;

    }

    /**
     * @return string
     */
    public function getClientIp(): string
    {

        return $this->clientIp;

    }

}