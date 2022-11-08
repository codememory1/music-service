<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Service\FlusherService;

class DeleteMultimedia
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly ImageUploader $imageUploader,
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader
    ) {
    }

    public function delete(Multimedia $multimedia): Multimedia
    {
        $this->deleteFiles($multimedia);

        $this->flusher->remove($multimedia);

        return $multimedia;
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