<?php

namespace App\Service\Platform\Google;

use App\Service\Platform\Interfaces\UserDataInterface;
use Google\Service\Oauth2;
use Google\Service\Oauth2\Userinfo;
use JetBrains\PhpStorm\Pure;

/**
 * Class UserData.
 *
 * @package App\Service\Platform\Google
 *
 * @author  Codememory
 */
class UserData implements UserDataInterface
{
    /**
     * @var Userinfo
     */
    private Userinfo $data;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->data = (new Oauth2($client->googleClient))->userinfo->get();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getUniqueId(): ?string
    {
        return $this->data->getId();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getName(): ?string
    {
        return $this->data->getName();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getEmail(): ?string
    {
        return $this->data->getEmail();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getPhoto(): ?string
    {
        return $this->data->getPicture();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getLocale(): ?string
    {
        return $this->data->getLocale();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function isVerifiedEmail(): bool
    {
        return $this->data->getVerifiedEmail();
    }
}