<?php

namespace App\UseCase\Multimedia;

use App\Entity\Multimedia;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;

final class DeleteMultimediaFiles
{
    public function __construct(
        private readonly ImageUploader $imageUploader,
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader
    ) {
    }

    public function process(Multimedia $multimedia): Multimedia
    {
        $this->deleteMedia($multimedia);
        $this->deleteImage($multimedia);
        $this->deleteSubtitles($multimedia);

        return $multimedia;
    }

    public function deleteMedia(Multimedia $multimedia): void
    {
        if ($multimedia->isTrack()) {
            $this->trackUploader->delete($multimedia->getMultimedia());
        } else {
            if ($multimedia->isClip()) {
                $this->clipUploader->delete($multimedia->getMultimedia());
            }
        }
    }

    public function deleteImage(Multimedia $multimedia): void
    {
        $this->imageUploader->delete($multimedia->getImage());
    }

    public function deleteSubtitles(Multimedia $multimedia): void
    {
        if (null !== $multimedia->getSubtitles()) {
            $this->subtitlesUploader->delete($multimedia->getSubtitles());
        }
    }
}