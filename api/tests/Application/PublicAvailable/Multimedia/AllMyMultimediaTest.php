<?php

namespace App\Tests\Application\PublicAvailable\Multimedia;

use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;

final class AllMyMultimediaTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    public const API_PATH = '/api/ru/public/user/multimedia/all';

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
    }
}