<?php

namespace App\Tests\Application\PublicAvailable\Session;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;

final class DeleteSessionTest extends AbstractApiTestCase
{
    use SecurityTrait;
    public const API_PATH = '/api/ru/public/user/session/{id}/delete';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->addParameter('id', 0);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    public function testSessionNotExist(): void
    {
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addParameter('id', 0);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    public function testSessionNotBelongToMe(): void
    {
        $userSessionForDelete = $this->authorize($this->createUser());
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH, ['id' => $userSessionForDelete->getId()]);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    public function testSuccessDelete(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->addParameter('id', $authorizedUserSession->getId());
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Сеанс успешно удален');

        $this->em()->clear();

        $this->assertNull($userSessionRepository->find($authorizedUserSession->getId()));
    }
}