<?php

namespace App\Tests\Security;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

/**
 * Class RegisterTest
 *
 * @package App\Tests\Security
 *
 * @author  Codememory
 */
class RegisterTest extends ApiTestCase
{

    /**
     * @return void
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testName(): void
    {

        static::createClient()->request('POST', env('app.api.url'));

        $this->assertJsonContains([
            'status' => 'error',
            'type'   => 'name_is_required'
        ]);

        $this->assertResponseStatusCodeSame(400);

    }

    public function testEmail(): void
    {

    }

    public function testPassword(): void
    {

    }

    public function testConfirmPassword(): void
    {

    }

    public function testUserExist(): void
    {

    }

    public function testRegister(): void
    {


    }

    public function testReRegister(): void
    {

    }

}
