<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UpsertMultimediaFile
{
    public function __construct(
        private readonly TrackUploader $trackUploader,
        private readonly ClipUploader $clipUploader,
        private readonly SubtitlesUploader $subtitlesUploader,
        private readonly ImageUploader $imageUploader
    ) {
    }

    public function uploadMedia(UploadedFile $file, Multimedia $multimedia): ?string
    {
        if (MultimediaTypeEnum::TRACK->name === $multimedia->getType()) {
            return $this->uploadTrack($file, $multimedia);
        }

        if (MultimediaTypeEnum::CLIP->name === $multimedia->getType()) {
            return $this->uploadClip($file, $multimedia);
        }

        return null;
    }

    public function uploadImage(UploadedFile $file, Multimedia $multimedia): string
    {
        $this->imageUploader->save($multimedia->getImage(), $file, 'image', $multimedia);

        return $this->imageUploader->getUploadedFile()->first();
    }

    public function uploadTrack(UploadedFile $file, Multimedia $multimedia): string
    {
        $this->trackUploader->save($multimedia->getMultimedia(), $file, 'multimedia', $multimedia);

        return $this->trackUploader->getUploadedFile()->first();
    }

    public function uploadClip(UploadedFile $file, Multimedia $multimedia): string
    {
        $this->clipUploader->save($multimedia->getMultimedia(), $file, 'multimedia', $multimedia);

        return $this->clipUploader->getUploadedFile()->first();
    }

    public function uploadSubtitles(UploadedFile $file, Multimedia $multimedia): string
    {
        $this->subtitlesUploader->save($multimedia->getSubtitles(), $file, 'subtitles', $multimedia);

        return $this->subtitlesUploader->getUploadedFile()->first();
    }
}