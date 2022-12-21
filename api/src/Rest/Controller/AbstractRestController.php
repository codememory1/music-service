<?php

namespace App\Rest\Controller;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Rest\Response\Interfaces\SuccessHttpResponseCollectorInterface;
use App\Security\AuthorizedUser;
use App\Security\Http\BearerToken;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractRestController extends AbstractController
{
    public function __construct(
        protected readonly AuthorizedUser $authorizedUser,
        protected readonly BearerToken $bearerToken,
        protected readonly SuccessHttpResponseCollectorInterface $successHttpResponseCollector
    ) {
    }

    final protected function getAuthorizedUser(): ?User
    {
        return $this->authorizedUser->fromBearer()->getUser();
    }

    final protected function response(array $data, PlatformCodeEnum $platformCode = PlatformCodeEnum::OUTPUT, array $headers = []): SuccessHttpResponseCollectorInterface
    {
        $this->successHttpResponseCollector->setHeaders($headers);
        $this->successHttpResponseCollector->setPlatformCode($platformCode);
        $this->successHttpResponseCollector->setHttpCode(Response::HTTP_OK);
        $this->successHttpResponseCollector->setData($data);

        return $this->successHttpResponseCollector;
    }

    final protected function responseData(
        ResponseDataInterface $responseData,
        array|Collection|EntityInterface $data,
        PlatformCodeEnum $platformCode = PlatformCodeEnum::OUTPUT,
        array $headers = []
    ): SuccessHttpResponseCollectorInterface {
        $this->successHttpResponseCollector->setHeaders($headers);
        $this->successHttpResponseCollector->setPlatformCode($platformCode);
        $this->successHttpResponseCollector->setHttpCode(Response::HTTP_OK);
        $this->successHttpResponseCollector->setData($responseData->setEntities($data)->getResponse());

        return $this->successHttpResponseCollector;
    }
}