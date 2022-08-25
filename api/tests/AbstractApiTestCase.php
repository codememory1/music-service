<?php

namespace App\Tests;

use App\Entity\Interfaces\EntityInterface;
use App\Enum\ResponseTypeEnum;
use App\Exception\Http\HttpException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use const JSON_ERROR_NONE;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractApiTestCase extends WebTestCase
{
    protected readonly EntityManagerInterface $em;
    private KernelBrowser $client;
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
        $this->client->catchExceptions(false);

        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function createRequest(string $url, string $method, array $data = []): ?Crawler
    {
        try {
            $crawler = $this->client->request($method, $url, $data);

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

    protected function em(): EntityManagerInterface
    {
        return self::getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected function persistFlush(EntityInterface $entity): void
    {
        $em = $this->em();

        $em->persist($entity);
        $em->flush();
    }

    protected function authorize(string $email): ?string
    {
        $userRepository = self::em()->getRepository(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (null === $user) {
            return null;
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