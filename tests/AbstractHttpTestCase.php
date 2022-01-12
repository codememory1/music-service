<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class AbstractHttpTestCase
 *
 * @package Tests
 *
 * @author  Codememory
 */
abstract class AbstractHttpTestCase extends TestCase
{

    /**
     * @var HttpClientInterface|null
     */
    private ?HttpClientInterface $httpClient = null;

    /**
     * @var ResponseInterface|null
     */
    private ?ResponseInterface $response = null;

    /**
     * @var Crawler|null
     */
    private ?Crawler $crawler = null;

    /**
     * @return void
     */
    protected function setUp(): void
    {

        $this->httpClient = HttpClient::create();
        $this->crawler = new Crawler();

    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return AbstractHttpTestCase
     * @throws TransportExceptionInterface
     */
    protected function request(string $url, string $method = 'GET', array $options = []): AbstractHttpTestCase
    {

        $options['headers']['Codememory-Type-Request'] = sprintf('testing,%s', env('app_key'));

        $this->response = $this->httpClient->request($method, $url, $options);

        return $this;

    }

    /**
     * @return $this
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function crawlerFromBody(): AbstractHttpTestCase
    {

        $this->crawler->add($this->response->getContent(false));

        return $this;

    }

    /**
     * @param int         $expected
     * @param string|null $message
     *
     * @return AbstractHttpTestCase
     * @throws TransportExceptionInterface
     */
    protected function assertStatus(int $expected, ?string $message = null): AbstractHttpTestCase
    {

        $this->assertEquals($expected, $this->response->getStatusCode(), $message ?: '');

        return $this;

    }

    /**
     * @param array       $expected
     * @param string|null $message
     *
     * @return AbstractHttpTestCase
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    protected function assertHeaders(array $expected, ?string $message = null): AbstractHttpTestCase
    {

        $this->assertEquals($expected, $this->response->getHeaders(), $message ?: '');

        return $this;

    }

    /**
     * @param array       $expected
     * @param string|null $message
     *
     * @return $this
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function assertApiResponse(array $expected, ?string $message = null): AbstractHttpTestCase
    {

        $body = json_decode($this->response->getContent(false), true);

        $this->assertEquals($expected, $body, $message ?: '');

        return $this;

    }

    /**
     * @param string      $expected
     * @param string|null $message
     *
     * @return $this
     */
    protected function assertHtml(string $expected, ?string $message = null): AbstractHttpTestCase
    {

        $this->assertEquals(new Crawler($expected), (object) $this->crawler, $message ?: '');

        return $this;

    }

}