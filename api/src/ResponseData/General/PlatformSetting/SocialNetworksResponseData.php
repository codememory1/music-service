<?php

namespace App\ResponseData\General\PlatformSetting;

use App\Entity\PlatformSetting;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class SocialNetworksResponseData extends AbstractResponseData
{
    #[RDCS\AsCustomProperty]
    #[RDCV\Callback('instagramCallback')]
    private ?string $instagram = null;

    #[RDCS\AsCustomProperty]
    #[RDCV\Callback('facebookCallback')]
    private ?string $facebook = null;

    #[RDCS\AsCustomProperty]
    #[RDCV\Callback('twitterCallback')]
    private ?string $twitter = null;

    public function instagramCallback(PlatformSetting $platformSetting): string
    {
        return $platformSetting->getValue()['instagram'];
    }

    public function facebookCallback(PlatformSetting $platformSetting): string
    {
        return $platformSetting->getValue()['facebook'];
    }

    public function twitterCallback(PlatformSetting $platformSetting): string
    {
        return $platformSetting->getValue()['twitter'];
    }
}