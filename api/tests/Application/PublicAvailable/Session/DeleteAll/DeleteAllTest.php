<?php

namespace App\Tests\Application\PublicAvailable\Session\DeleteAll;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class DeleteAllTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/user/session/all/delete';

    protected function setUp(): void
    {
        $this->authorize('developer@gmail.com');
        $this->authorize('developer@gmail.com');

        $authorizedUserSession = $this->authorize('developer@gmail.com');

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_DELETE);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addReference('authorizedUserSession', $authorizedUserSession);
    }

    public function testSuccessDelete(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $authorizedUserSession = $this->browser->getReference('authorizedUserSession');

        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Сеансы успешно удалены');

        $this->em()->clear();

        $this->assertEmpty($userSessionRepository->findAllTemp($authorizedUserSession->getUser()));
    }
}