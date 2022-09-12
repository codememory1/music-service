<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class DeleteAlbumService extends AbstractService
{
    #[Required]
    public ?ImageUploader $imageUploader = null;

    #[Required]
    public ?TrackUploader $trackUploader = null;

    #[Required]
    public ?ClipUploader $clipUploader = null;

    #[Required]
    public ?SubtitlesUploader $subtitlesUploader = null;

    public function delete(Album $album): Album
    {
        $this->imageUploader->delete($album->getImage());
        $this->flusherService->remove($album);

        foreach ($album->getMultimedia() as $multimedia) {
            $this->deleteMultimediaFiles($multimedia);
        }

        return $album;
    }

    public function request(Album $album): JsonResponse
    {
        $this->delete($album);

        return $this->responseCollection->successDelete('album@successDelete');
    }

    private function deleteMultimediaFiles(Multimedia $multimedia): void
    {
        if ($multimedia->isTrack()) {
            $this->trackUploader->delete($multimedia->getMultimedia());
        } else {
            if ($multimedia->isClip()) {
                $this->clipUploader->delete($multimedia->getMultimedia());
            }
        }

        $this->imageUploader->delete($multimedia->getImage());

        if (null !== $multimedia->getSubtitles()) {
            $this->subtitlesUploader->delete($multimedia->getSubtitles());
        }
    }
}