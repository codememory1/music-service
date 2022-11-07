<?php

namespace App\Service\Album;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\FlusherService;

class DeleteAlbum
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly ImageUploader $imageUploader,
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader
    ) {
    }

    public function delete(Album $album): Album
    {
        $this->imageUploader->delete($album->getImage());
        $this->flusher->remove($album);

        foreach ($album->getMultimedia() as $multimedia) {
            $this->deleteMultimediaFiles($multimedia);
        }

        return $album;
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