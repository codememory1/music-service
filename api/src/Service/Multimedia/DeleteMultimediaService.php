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

/**
 * Class DeleteMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
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
        $this->imageUploader->delete($multimedia->getImage());

        if ($multimedia->isTrack()) {
            $this->trackUploader->delete($multimedia->getMultimedia());
        } else {
            if ($multimedia->isClip()) {
                $this->clipUploader->delete($multimedia->getMultimedia());
            }
        }

        $this->subtitlesUploader->delete($multimedia->getSubtitles());

        $this->flusherService->remove($multimedia);

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->delete($multimedia);

        return $this->responseCollection->successDelete('multimedia@successDelete');
    }
}