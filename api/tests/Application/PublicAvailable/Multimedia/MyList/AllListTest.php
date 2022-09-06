<?php

namespace App\Tests\Application\PublicAvailable\Multimedia\MyList;

use App\Enum\MultimediaTypeEnum;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\BaseRequestTrait;

final class AllListTest extends AbstractApiTestCase
{
    use BaseRequestTrait;
    public const API_PATH = '/api/ru/public/user/multimedia/all';

    protected function setUp(): void
    {
        $artist = $this->createArtistAccount();
        $authorizedUserSession = $this->authorize($artist);

        $album = $this->createAlbum($authorizedUserSession);

        $this->uploadMultimedia($authorizedUserSession, $album, MultimediaTypeEnum::TRACK, 'music_5.8mb_02-23time.wav');

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setBearerAuth($authorizedUserSession->getAccessToken());
    }

    public function testFetchList(): void
    {
        $this->browser->sendRequest();

        dd($this->browser->getResponseData());
    }
}