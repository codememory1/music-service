<?php

namespace App\Tests\Application\PublicAvailable\Session\Delete;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class DeleteTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/session/{id}/delete';

    protected function setUp(): void
    {
        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addReference('authorizedUserSession', $authorizedUserSession);
        $this->browser->addReference('artistSession', $this->authorize('artist@gmail.com'));
    }

    public function testSessionNotExist(): void
    {
        $this->browser->addParameter('id', 0);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    public function testSessionNotBelongToMe(): void
    {
        $this->browser->addParameter('id', $this->browser->getReference('artistSession')->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    public function testSuccessDelete(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $authorizedUserSession = $this->browser->getReference('authorizedUserSession');

        $this->browser->addParameter('id', $authorizedUserSession->getId());
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Сеанс успешно удален');

        $this->em()->clear();

        $this->assertNull($userSessionRepository->find($authorizedUserSession->getId()));
    }
}