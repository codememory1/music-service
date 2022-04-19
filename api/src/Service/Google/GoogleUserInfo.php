<?php

namespace App\Service\Google;

use App\Interfaces\SocialNetworkUserInfoInterface;
use Google\Service\Oauth2\Userinfo;
use Google_Service_Oauth2;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class GoogleUserInfo.
 *
 * @package App\Service\Google
 *
 * @author  Codememory
 */
class GoogleUserInfo implements SocialNetworkUserInfoInterface
{
    /**
     * @var Userinfo
     */
    private Userinfo $userInfo;

    /**
     * @param GoogleOAuthClient $client
     */
    public function __construct(GoogleOAuthClient $client)
    {
        $this->userInfo = (new Google_Service_Oauth2($client))->userinfo->get();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getUniqueId(): ?string
    {
        return empty($this->userInfo->getId()) ? null : $this->userInfo->getId();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getName(): ?string
    {
        return empty($this->userInfo->getName()) ? null : $this->userInfo->getName();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getSurname(): ?string
    {
        return empty($this->userInfo->getFamilyName()) ? null : $this->userInfo->getFamilyName();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getEmail(): ?string
    {
        return empty($this->userInfo->getEmail()) ? null : $this->userInfo->getEmail();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getPhoto(): ?string
    {
        return empty($this->userInfo->getPicture()) ? null : $this->userInfo->getPicture();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getLocale(): ?string
    {
        return empty($this->userInfo->getLocale()) ? null : $this->userInfo->getLocale();
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    #[ArrayShape([
        'id' => 'null|string',
        'name' => 'null|string',
        'surname' => 'null|string',
        'email' => 'null|string',
        'photo' => 'null|string',
        'locale' => 'null|string'
    ])]
    public function __toArray(): array
    {
        return [
            'id' => $this->getUniqueId(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'email' => $this->getEmail(),
            'photo' => $this->getPhoto(),
            'locale' => $this->getLocale()
        ];
    }
}