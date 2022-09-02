<?php

namespace App\Service\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class AddMultimediaService extends AbstractService
{
    #[Required]
    public ?SaveMultimediaService $saveMultimediaService = null;

    public function add(MultimediaDto $multimediaDto, User $toUser): Multimedia
    {
        $this->validate($multimediaDto);

        $multimedia = $multimediaDto->getEntity();

        $multimedia->setUser($toUser);
        $multimedia->setDraftStatus();

        $this->saveMultimediaService->make($multimediaDto, $multimedia);

        return $multimedia;
    }

    public function request(MultimediaDto $multimediaDto, User $toUser): JsonResponse
    {
        $multimedia = $this->add($multimediaDto, $toUser);

        return $this->responseCollection->successCreate('multimedia@successAdd', [
            'id' => $multimedia->getId()
        ]);
    }
}