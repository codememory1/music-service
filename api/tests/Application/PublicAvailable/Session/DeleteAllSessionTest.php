<?php

namespace App\Tests\Application\PublicAvailable\Session;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class DeleteAllSessionTest extends AbstractApiTestCase
{
    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/session/all/delete', 'DELETE');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testSuccessDelete(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);

        // Create three sessions
        $this->authorize('developer@gmail.com');
        $this->authorize('developer@gmail.com');

        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/all/delete', 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Сеансы успешно удалены');

        $this->em()->clear();

        $this->assertEmpty($userSessionRepository->findAllTemp($authorizedUser->getUser()));
    }
}