<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Ergebnis\Json\Pointer\JsonPointer;
use Ergebnis\Json\SchemaValidator\Json;
use Ergebnis\Json\SchemaValidator\SchemaValidator;
use const JSON_ERROR_NONE;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractApiTestCase.
 *
 * @package App\Tests
 *
 * @author  Codememory
 */
abstract class AbstractApiTestCase extends WebTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected readonly EntityManagerInterface $em;

    /**
     * @var KernelBrowser
     */
    private KernelBrowser $client;

    /**
     * @var SchemaValidator
     */
    private SchemaValidator $jsonSchemaValidator;

    /**
     * @var array<Json>
     */
    private array $schemes;

    /**
     * @param null|string $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        self::ensureKernelShutdown();

        $this->client = static::createClient();
        $this->jsonSchemaValidator = new SchemaValidator();

        $this->schemes['api_response'] = $this->readSchema('api_response.json');
        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $data
     *
     * @return Crawler
     */
    protected function createRequest(string $url, string $method, array $data = []): Crawler
    {
        return $this->client->request($method, $url, $data);
    }

    /**
     * @return void
     */
    protected function clearBase(): void
    {
        shell_exec('bin/console doctrine:fixtures:load --env=test');
    }

    /**
     * @param null|string $message
     *
     * @return void
     */
    protected function assertApiResponse(?string $message = null): void
    {
        $jsonSchemaValidator = (clone $this->jsonSchemaValidator)->validate(
            Json::fromString(json_encode($this->getApiResponse())),
            $this->getSchema('api_response'),
            JsonPointer::document()
        );

        $this->assertEquals(
            true,
            $jsonSchemaValidator->isValid(),
            $message ?? 'Api response did not match schema config/scheme/api_response.json'
        );
    }

    /**
     * @param int         $expect
     * @param null|string $message
     *
     * @return void
     */
    protected function assertApiStatusCode(int $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->getApiResponse()['status_code'], $message ?? '');
    }

    /**
     * @param string      $expect
     * @param null|string $message
     *
     * @return void
     */
    protected function assertApiType(string $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->getApiResponse()['type'], $message ?? '');
    }

    /**
     * @param array|string $expect
     * @param null|string  $message
     *
     * @return void
     */
    protected function assertApiMessage(string|array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->getApiResponse()['message'], $message ?? '');
    }

    /**
     * @param array       $expect
     * @param null|string $message
     *
     * @return void
     */
    protected function assertApiData(array $expect, ?string $message = null): void
    {
        $this->assertEquals($expect, $this->getApiResponse()['data'], $message ?? '');
    }

    /**
     * @return null|array
     */
    protected function getApiResponse(): ?array
    {
        $this->saveRequestResponse();

        $response = json_decode($this->client->getResponse()->getContent(), true);

        if (JSON_ERROR_NONE === json_last_error()) {
            return $response;
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return null|Json
     */
    protected function readSchema(string $name): ?Json
    {
        $fullPath = sprintf('%s/../config/scheme/%s', __DIR__, $name);

        if (file_exists($fullPath)) {
            return Json::fromString(file_get_contents($fullPath));
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return null|Json
     */
    protected function getSchema(string $name): ?Json
    {
        return $this->schemes[$name] ?? null;
    }

    /**
     * @return void
     */
    private function saveRequestResponse(): void
    {
        file_put_contents(
            __DIR__ . '/../var/log/test_response.txt',
            $this->client->getResponse()->getContent()
        );
    }
}