<?php

namespace App\Tests\Traits;

use App\Entity\Album;
use App\Entity\UserSession;
use App\Enum\AlbumTypeEnum;
use Symfony\Component\HttpFoundation\Request;

trait MultimediaTrait
{
    private function createAlbum(UserSession $authorizedUserSession): ?Album
    {
        $albumRepository = $this->em()->getRepository(Album::class);

        $this->browser->createRequest('/api/ru/public/album/create');
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', AlbumTypeEnum::SINGLE->name);
        $this->browser->addRequestData('title', 'Album title');
        $this->browser->addRequestData('description', 'Description for test album');
        $this->browser->addFile('image', $this->getFilePathFromFixture('image_1.3mb.jpg'));
        $this->browser->sendRequest();

        if (null !== $this->browser->getResponseData('id')) {
            return $albumRepository->find($this->browser->getResponseData('id'));
        }

        return null;
    }
}