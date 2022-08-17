<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class DeleteMultimediaService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    #[Required]
    public ?TrackUploader $trackUploader = null;

    #[Required]
    public ?ClipUploader $clipUploader = null;

    #[Required]
    public ?SubtitlesUploader $subtitlesUploader = null;

    public function delete(Multimedia $multimedia): Multimedia
    {
        $this->deleteFiles($multimedia);

        $this->flusherService->remove($multimedia);

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->delete($multimedia);

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }

    private function deleteFiles(Multimedia $multimedia): void
    {
        $this->imageUploader->delete($multimedia->getImage());

        if ($multimedia->isTrack()) {
            $this->trackUploader->delete($multimedia->getMultimedia());
        } elseif ($multimedia->isClip()) {
            $this->clipUploader->delete($multimedia->getMultimedia());
        }

        if (null !== $multimedia->getSubtitles()) {
            $this->subtitlesUploader->delete($multimedia->getSubtitles());
        }
    }
}