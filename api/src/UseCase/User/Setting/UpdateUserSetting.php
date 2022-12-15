<?php

namespace App\UseCase\User\Setting;

use App\Dto\Transfer\UserSettingDto;
use App\Entity\UserSetting;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateUserSetting
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(UserSettingDto $dto): UserSetting
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}