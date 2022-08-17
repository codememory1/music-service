<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Service\Attribute\Required;

class SaveAlbumService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function make(AlbumDto $albumDto, Album $album): Album
    {
        $album->setImage($this->uploadImage($albumDto->image, $album));

        $this->flusherService->save($album);

        return $album;
    }

    private function uploadImage(UploadedFile $image, Album $album): string
    {
        return $this->simpleFileUpload($this->imageUploader, $album->getImage(), $image, 'image', $album);
    }
}