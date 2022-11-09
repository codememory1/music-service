<?php

namespace App\Service\MultimediaTimeCode;

use App\Dto\Transfer\MultimediaTimeCodeDto;
use App\Entity\Multimedia;
use App\Exception\Http\InvalidInputValidationException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\MultimediaTimeCodeRepository;
use Doctrine\Common\Collections\Collection;

final class AddTimeCode
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly MultimediaTimeCodeRepository $multimediaTimeCodeRepository
    ) {
    }

    public function add(Multimedia $multimedia, MultimediaTimeCodeDto $dto): Collection
    {
        $this->validator->validate($dto);

        $multimediaTimeCode = $this->multimediaTimeCodeRepository->findByMaxToTime($multimedia);

        if (null !== $multimediaTimeCode && $dto->fromTime < $multimediaTimeCode->getToTime()) {
            throw InvalidInputValidationException::multimediaTimeCodeAlreadyAdded();
        }

        if ($dto->toTime > $multimedia->getMetadata()->getDuration()) {
            throw InvalidInputValidationException::multimediaTimeCodeToMoreDuration();
        }

        $multimedia->addTimeCode($dto->getEntity());

        $this->flusher->save($multimedia);

        return $multimedia->getTimeCodes();
    }
}