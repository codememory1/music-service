<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Exception\Http\HttpException;
use App\Security\Auth\AuthorizationToken;
use Doctrine\ORM\EntityManagerInterface;
use const JSON_ERROR_NONE;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractApiTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    private array $response = [
        'status_code' => null,
        'type' => null,
        'message' => null,
        'data' => []
    ];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        self::ensureKernelShutdown();

        $this->client = static::createClient();
        $this->client->enableProfiler();
        $this->client->catchExceptions(false);
    }

    protected function em(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }

    /**
     * @template Service
     * @psalm-param  Service $service
     *
     * @return Service
     */
    protected function getService(string $service): object
    {
        return self::getContainer()->get($service);
    }

    /**
     * @param array<Cookie> $cookies
     */
    protected function createRequest(string $url, string $method, array $data = [], array $server = [], array $cookies = []): ?Crawler
    {
        try {
            foreach ($cookies as $cookie) {
                $this->client->getCookieJar()->set($cookie);
            }

            $crawler = $this->client->request($method, $url, $data, server: $server);

            $this->response = $this->getProcessedResponse();

            return $crawler;
        } catch (HttpException $e) {
            $this->response['status_code'] = $e->getStatusCode();
            $this->response['type'] = $e->getResponseType()->name;
            $this->response['message'] = $e->getMessageTranslationKey();

            return null;
        }
    }

    protected function clearBase(): void
    {
        shell_exec('bin/console doctrine:fixtures:load --env=test');
    }

    protected function authorize(string $email): ?UserSession
    {
        $authorizationToken = $this->getService(AuthorizationToken::class);
        $userRepository = $this->em()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (null !== $user) {
            $userSession = new UserSession();

            $authorizationToken->generateRefreshToken($user);
            $authorizationToken->generateRefreshToken($user);

            $userSession->setUser($user);
            $userSession->setAccessToken($authorizationToken->getAccessToken());
            $userSession->setRefreshToken($authorizationToken->getRefreshToken());

            $this->em()->persist($userSession);
            $this->em()->flush();

            return $userSession;
        }

        return null;
    }

    protected function assertApiStatusCode(int $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['status_code'], $message ?? '');
    }

    protected function assertApiType(ResponseTypeEnum $expect, ?string $message = null): void
    {
        $this->assertEquals($expect->name, $this->response['type'], $message ?? '');
    }

    protected function assertApiMessage(string|array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['message'], $message ?? '');
    }

    protected function assertApiData(array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->response['data'], $message ?? '');
    }

    protected function getApiResponseData(): ?array
    {
        return $this->response['data'];
    }

    protected function getApiResponse(): array
    {
        return $this->response;
    }

    private function getProcessedResponse(): array
    {
        $this->saveRequestResponse();

        $response = json_decode($this->client->getResponse()->getContent(), true);

        if (JSON_ERROR_NONE === json_last_error()) {
            return $response;
        }

        return [];
    }

    private function saveRequestResponse(): void
    {
        file_put_contents(
            __DIR__ . '/../var/log/test_response.txt',
            $this->client->getResponse()->getContent()
        );
    }
}