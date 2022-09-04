<?php

namespace App\Tests;

use App\Dto\Transformer\UserTransformer;
use App\Entity\User;
use App\Entity\UserSession;
use App\Enum\UserSessionTypeEnum;
use App\Security\Auth\AuthorizationToken;
use App\Service\UserSession\CollectorSessionService;
use App\Tests\Traits\AssertTrait;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use function is_string;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractApiTestCase extends WebTestCase
{
    use AssertTrait;
    protected KernelBrowser $client;
    protected BrowserKitClient $browser;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        self::ensureKernelShutdown();

        $this->client = static::createClient();
        $this->client->enableProfiler();
        $this->client->catchExceptions(false);
        $this->browser = new BrowserKitClient($this->client);
    }

    protected function em(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }

    /**
     * @template Service
     * @psalm-param Service $service
     *
     * @return Service
     */
    protected function getService(string $service): object
    {
        return self::getContainer()->get($service);
    }

    protected function getProjectDir(): string
    {
        return $this->getService(KernelInterface::class)->getProjectDir();
    }

    protected function getFilePathFromFixture(string $filename): string
    {
        return "{$this->getProjectDir()}/src/DataFixtures/Files/{$filename}";
    }

    protected function clearBase(): void
    {
        shell_exec('bin/console doctrine:fixtures:load --env=test');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function authorize(User|string $userOrEmail, bool $isActive = true): ?UserSession
    {
        $authorizationToken = $this->getService(AuthorizationToken::class);
        $userRepository = $this->em()->getRepository(User::class);
        $user = is_string($userOrEmail) ? $userRepository->findOneBy(['email' => $userOrEmail]) : $userOrEmail;

        if (null !== $user) {
            $userTransformer = $this->getService(UserTransformer::class);
            $userDto = $userTransformer->transformFromArray(['ip' => '127.0.0.1']);
            $userSession = $this->getService(CollectorSessionService::class)->collect($userDto, $user, UserSessionTypeEnum::TEMP);

            $authorizationToken->generateAccessToken($user);
            $authorizationToken->generateRefreshToken($user);

            $userSession->setAccessToken($authorizationToken->getAccessToken());
            $userSession->setRefreshToken($authorizationToken->getRefreshToken());
            $userSession->setLastActivity(new DateTimeImmutable());
            $userSession->setIsActive($isActive);

            $this->em()->persist($userSession);
            $this->em()->flush();

            return $userSession;
        }

        return null;
    }
}