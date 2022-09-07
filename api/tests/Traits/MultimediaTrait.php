<?php

namespace App\Tests\Traits;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Entity\MultimediaCategory;
use App\Entity\UserSession;
use App\Enum\AlbumTypeEnum;
use App\Enum\MultimediaTypeEnum;
use App\Tests\Application\PublicAvailable\Multimedia\UploadMultimediaTest;
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

    private function uploadMultimedia(UserSession $authorizedUserSession, Album $album, MultimediaTypeEnum $multimediaType, string $multimediaFilename): Multimedia
    {
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);

        $this->browser->createRequest(UploadMultimediaTest::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->addRequestData('type', $multimediaType->name);
        $this->browser->addRequestData('album', $album->getId());
        $this->browser->addRequestData('title', 'Multimedia title');
        $this->browser->addRequestData('description', 'Multimedia description');
        $this->browser->addRequestData('multimedia', $this->getFilePathFromFixture($multimediaFilename));
        $this->browser->addRequestData('category', $multimediaCategoryRepository->findByTitle('multimediaCategoryTitle@sport')->getId());
        $this->browser->addRequestData('text', ['ru' => 'Русский текст']);
        $this->browser->addRequestData('subtitles', $this->getFilePathFromFixture('subtitles_202B_valid.srt'));
        $this->browser->addRequestData('is_obscene_words', 'true');
        $this->browser->addRequestData('image', $this->getFilePathFromFixture('image_2mb.png'));
        $this->browser->addRequestData('producer', 'Codememory, Jon');
        $this->browser->addRequestData('performers', ['developer@gmail.com', 'user@gmail.com']);
        $this->browser->sendRequest();

        return $multimediaRepository->find($this->browser->getResponseData('id'));
    }
}