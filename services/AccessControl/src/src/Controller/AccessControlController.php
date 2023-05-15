<?php

namespace App\Controller;

use App\Enum\TranslationKey;
use App\ResponseControl\AccessKeyResponseControl;
use App\Service\AccessControlAuthorization;
use Codememory\ApiBundle\Controller\AbstractController;
use Codememory\ApiBundle\ResponseSchema\Interfaces\ResponseSchemaInterface;
use Codememory\ApiBundle\ResponseSchema\View\MessageView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class AccessControlController extends AbstractController
{
    #[Route('/check-valid', methods: Request::METHOD_GET)]
    public function checkValid(AccessControlAuthorization $accessControlAuthorization, AccessKeyResponseControl $responseControl, string $accessControlHost): ResponseSchemaInterface
    {
        if (null !== $accessKey = $accessControlAuthorization->getAccessKey()) {
            $responseControl->setData($accessKey);

            return $this->responseControl(200, $responseControl->collect());
        }

        return $this->response(401, new MessageView(TranslationKey::AUTH_ACCESS_KEY_INVALID));
    }
}