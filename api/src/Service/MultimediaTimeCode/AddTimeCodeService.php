<?php

namespace App\Service\MultimediaTimeCode;

use App\Dto\Transfer\MultimediaTimeCodeDto;
use App\Entity\Multimedia;
use App\Entity\MultimediaTimeCode;
use App\Exception\Http\InvalidInputValidationException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AddTimeCodeService extends AbstractService
{
    public function add(Multimedia $multimedia, MultimediaTimeCodeDto $multimediaTimeCodeDto): Multimedia
    {
        $this->validate($multimediaTimeCodeDto);

        $multimediaTimeCodeRepository = $this->em->getRepository(MultimediaTimeCode::class);

        if (null !== $multimediaTimeCodeRepository->findByAnyTime($multimedia, $multimediaTimeCodeDto->fromTime, $multimediaTimeCodeDto->toTime)) {
            throw InvalidInputValidationException::multimediaTimeCodeAlreadyAdded();
        }

        if ($multimediaTimeCodeDto->toTime > $multimedia->getMetadata()->getDuration()) {
            throw InvalidInputValidationException::multimediaTimeCodeToMoreDuration();
        }

        $multimedia->addTimeCode($multimediaTimeCodeDto->getEntity());

        $this->flusherService->save($multimedia);

        return $multimedia;
    }

    public function request(Multimedia $multimedia, MultimediaTimeCodeDto $multimediaTimeCodeDto): JsonResponse
    {
        $this->add($multimedia, $multimediaTimeCodeDto);

        return $this->responseCollection->successCreate('multimediaTimeCode@successAdd');
    }
}