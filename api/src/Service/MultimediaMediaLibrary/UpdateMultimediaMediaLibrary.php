<?php

namespace App\Service\MultimediaMediaLibrary;

use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\MultimediaMediaLibrary;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\FileUploader\Uploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpdateMultimediaMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly Uploader $fileUploader,
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function update(MultimediaMediaLibraryDto $dto): MultimediaMediaLibrary
    {
        $this->validator->validate($dto);

        $multimediaMediaLibrary = $dto->getEntity();

        $multimediaMediaLibrary->setImage($this->uploadImage($dto->image, $multimediaMediaLibrary));

        $this->flusher->save();

        return $multimediaMediaLibrary;
    }

    private function uploadImage(UploadedFile $image, MultimediaMediaLibrary $multimediaMediaLibrary): ?string
    {
        return $this->fileUploader->simpleUpload(
            $this->imageUploader,
            $multimediaMediaLibrary->getImage(),
            $image,
            'image',
            $multimediaMediaLibrary
        );
    }
}