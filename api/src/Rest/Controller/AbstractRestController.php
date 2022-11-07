<?php

namespace App\Rest\Controller;

use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Rest\Response\HttpResponse;
use App\Rest\Response\Scheme\HttpSuccessScheme;
use App\Security\AuthorizedUser;
use App\Security\Http\BearerToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractRestController extends AbstractController
{
    public function __construct(
        protected readonly AuthorizedUser $authorizedUser,
        protected readonly BearerToken $bearerToken,
        protected readonly HttpResponse $httpResponse
    ) {
    }

    final protected function getAuthorizedUser(): ?User
    {
        return $this->authorizedUser->fromBearer()->getUser();
    }

    final protected function response(array $data, PlatformCodeEnum $platformCode = PlatformCodeEnum::OUTPUT, array $headers = []): JsonResponse
    {
        $scheme = new HttpSuccessScheme(200, $platformCode, $data);

        return $this->httpResponse->getResponse($scheme, $headers);
    }

    final protected function responseData(ResponseDataInterface $responseData, PlatformCodeEnum $platformCode = PlatformCodeEnum::OUTPUT, array $headers = []): JsonResponse
    {
        $scheme = new HttpSuccessScheme(200, $platformCode, $responseData->getResponse());

        return $this->httpResponse->getResponse($scheme, $headers);
    }
}