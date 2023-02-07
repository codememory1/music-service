<?php

namespace App\Controller\PublicAvailable;

use App\Enum\PlatformSettingEnum;
use App\Repository\PlatformSettingRepository;
use App\ResponseData\General\PlatformSetting\SocialNetworksResponseData;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Rest\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/platform/setting')]
final class PlatformSettingController extends AbstractRestController
{
    #[Route('/social-networks', methods: Request::METHOD_GET)]
    public function allSocialNetworks(SocialNetworksResponseData $responseData, PlatformSettingRepository $platformSettingRepository): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $platformSettingRepository->getSetting(PlatformSettingEnum::SOCIAL_NETWORK));
    }
}