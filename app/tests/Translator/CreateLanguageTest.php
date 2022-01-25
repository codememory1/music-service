<?php

namespace App\Tests\Translator;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CreateLanguageTest
 *
 * @package App\Tests\Translator
 *
 * @author  Danil
 */
class CreateLanguageTest extends WebTestCase
{

    public function testSomething(): void
    {
        $response = static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

}
