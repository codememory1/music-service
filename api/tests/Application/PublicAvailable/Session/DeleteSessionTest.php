<?php

namespace App\Tests\Application\PublicAvailable\Session;

use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\SecurityTrait;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class DeleteSessionTest extends AbstractApiTestCase
{
    use SecurityTrait;

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/session/0/delete', 'DELETE');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSessionNotExist(): void
    {
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/user/session/0/delete', 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testSessionNotBelongToMe(): void
    {
        $userSessionForDelete = $this->authorize($this->createUser());
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest("/api/ru/public/user/session/{$userSessionForDelete->getId()}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@userSession');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessDelete(): void
    {
        $userSessionRepository = $this->em()->getRepository(UserSession::class);
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest("/api/ru/public/user/session/{$authorizedUser->getId()}/delete", 'DELETE', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::DELETE);
        $this->assertApiMessage('Сеанс успешно удален');

        $this->em()->clear();

        $this->assertNull($userSessionRepository->find($authorizedUser->getId()));
    }
}