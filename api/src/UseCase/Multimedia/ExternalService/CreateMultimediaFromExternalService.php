<?php

namespace App\UseCase\Multimedia\ExternalService;

use App\Dto\Transfer\MultimediaExternalServiceDto;
use App\Entity\MultimediaExternalService;
use App\Entity\User;
use App\Enum\PlatformSettingEnum;
use App\Exception\Http\FailedException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\PlatformSetting;

final class CreateMultimediaFromExternalService
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly PlatformSetting $platformSetting
    ) {
    }

    public function process(MultimediaExternalServiceDto $dto, User $owner): MultimediaExternalService
    {
        $this->validator->validate($dto);

        $allowedServices = $this->platformSetting->get(PlatformSettingEnum::ALLOWED_MULTIMEDIA_EXTERNAL_SERVICES);

        if (false === in_array($dto->serviceName->name, $allowedServices, true)) {
            throw FailedException::failedNotAllowedMultimediaExternalService();
        }

        $multimediaExternalService = $dto->getEntity();

        $multimediaExternalService->setUser($owner);

        $this->flusher->save($multimediaExternalService);

        return $multimediaExternalService;
    }
}