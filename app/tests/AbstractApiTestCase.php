<?php

namespace App\Tests;

use App\Tests\Translator\UpdateLanguageTest;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiTestCase
 *
 * @package App\Tests
 *
 * @author  Codememory
 */
abstract class AbstractApiTestCase extends WebTestCase
{

    protected const API_PATH = null;
    protected const API_RESPONSE_SCHEMA = [
        'status'      => 'string',
        'status_code' => 'int',
        'message'     => [
            'type' => 'string',
            'name' => 'string',
            'text' => 'string'
        ],
        'data'        => 'array'
    ];

    /**
     * @var string|null
     */
    protected ?string $apiPath = null;

    /**
     * @var Generator|null
     */
    protected ?Generator $faker = null;

    /**
     * @var KernelBrowser|null
     */
    protected ?KernelBrowser $client = null;

    /**
     * @return void
     */
    protected function setUp(): void
    {

        $this->faker = Factory::create('en');

        parent::setUp();

    }

    /**
     * @return void
     */
    protected function clearBase(): void
    {

        shell_exec('bin/console doctrine:schema:drop --env=test --force');
        shell_exec('bin/console doctrine:schema:create --env=test');

    }

    /**
     * @param array  $params
     * @param string $method
     *
     * @return void
     */
    protected function createRequest(array $params = [], string $method = 'POST'): void
    {

        $client = static::createClient();
        $apiPath = trim($this->apiPath, '/');
        $uri = sprintf('/api/%s/en/%s', $_SERVER['API_VERSION'], $apiPath);

        $client->request($method, $uri, $params);

        $this->client = $client;

    }

    /**
     * @return void
     */
    protected function assertSuccessApiResponseSchema(): void
    {

        $status = true;
        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $status = false;
        } else {
            if (!is_string($jsonResponse['status'] ?? null)) {
                $status = false;
            }

            if ($status && !is_int($jsonResponse['status_code'] ?? null)) {
                $status = false;
            }

            if ($status && (!array_key_exists('message', $jsonResponse) || !is_string($jsonResponse['message']['type'] ?? null))) {
                $status = false;
            }

            if ($status && (!array_key_exists('message', $jsonResponse) || !is_string($jsonResponse['message']['name'] ?? null))) {
                $status = false;
            }

            if ($status && (!array_key_exists('message', $jsonResponse) || !is_string($jsonResponse['message']['text'] ?? null))) {
                $status = false;
            }

            if ($status && !is_array($jsonResponse['data'] ?? null)) {
                $status = false;
            }
        }

        $message = sprintf(
            'Expected response scheme api %s, but came %s',
            json_encode(self::API_RESPONSE_SCHEMA),
            json_encode($jsonResponse)
        );

        $this->assertEquals(true, $status, $message);

    }

    /**
     * @param string $expected
     * @param string $message
     *
     * @return void
     */
    protected function assertStatus(string $expected, string $message = ''): void
    {

        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        $this->assertEquals($expected, $jsonResponse['status'], $message);

    }

    /**
     * @param int    $expected
     * @param string $message
     *
     * @return void
     */
    protected function assertStatusCode(int $expected, string $message = ''): void
    {

        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        $this->assertEquals($expected, $jsonResponse['status_code'], $message);

    }

    /**
     * @param string $expected
     * @param string $message
     *
     * @return void
     */
    protected function assertMessageType(string $expected, string $message = ''): void
    {

        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        $this->assertEquals($expected, $jsonResponse['message']['type'], $message);

    }

    /**
     * @param string $expected
     * @param string $message
     *
     * @return void
     */
    protected function assertMessageName(string $expected, string $message = ''): void
    {

        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        $this->assertEquals($expected, $jsonResponse['message']['name'], $message);

    }

    /**
     * @param array  $expected
     * @param string $message
     *
     * @return void
     */
    protected function assertDataEquals(array $expected, string $message = ''): void
    {

        $jsonResponse = json_decode($this->getClientResponse()->getContent(), true);

        $this->assertEquals($expected, $jsonResponse['data'], $message);

    }

    /**
     * @param string $status
     * @param int    $statusCode
     * @param string $messageType
     * @param string $messageName
     *
     * @return void
     */
    protected function apiResponseAssertsGroup(string $status, int $statusCode, string $messageType, string $messageName): void
    {

        $this->assertSuccessApiResponseSchema();
        $this->assertStatus($status);
        $this->assertStatusCode($statusCode);
        $this->assertResponseStatusCodeSame($statusCode);
        $this->assertMessageType($messageType);
        $this->assertMessageName($messageName);

    }

    /**
     * @return Response
     */
    private function getClientResponse(): Response
    {

        return $this->client->getResponse();

    }

}