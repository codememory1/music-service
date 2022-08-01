<?php

namespace App\Service\MultimediaMediaLibrary;

use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\MultimediaMediaLibrary;
use App\Rest\S3\Uploader\ImageUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateMultimediaMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class UpdateMultimediaMediaLibraryService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    public function update(MultimediaMediaLibraryDto $multimediaMediaLibraryDto): MultimediaMediaLibrary
    {
        $this->validate($multimediaMediaLibraryDto);

        $multimediaMediaLibrary = $multimediaMediaLibraryDto->getEntity();

        $multimediaMediaLibrary->setImage($this->uploadImage($multimediaMediaLibraryDto->image, $multimediaMediaLibrary));

        $this->flusherService->save();

        return $multimediaMediaLibrary;
    }

    public function request(MultimediaMediaLibraryDto $multimediaMediaLibraryDto): JsonResponse
    {
        $this->update($multimediaMediaLibraryDto);

        return $this->responseCollection->successUpdate('multimedia@successUpdate');
    }

    private function uploadImage(UploadedFile $image, MultimediaMediaLibrary $multimediaMediaLibrary): ?string
    {
        return $this->simpleFileUpload(
            $this->imageUploader,
            $multimediaMediaLibrary->getImage(),
            $image,
            'image',
            $multimediaMediaLibrary
        );
    }
}