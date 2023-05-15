<?php

namespace App\UseCase\Closed;

use App\DTO\Closed\UpdatePreferenceDTO;
use App\Repository\PreferenceRepository;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\Validator\Assert\AssertValidator;

final class UpdatePreferences
{
    public function __construct(
        private readonly AssertValidator $validator,
        private readonly PreferenceRepository $preferenceRepository,
    ) {
    }

    /**
     * @throws HttpException
     */
    public function process(UpdatePreferenceDTO $dto): void
    {
        $this->validator->validate($dto);

        foreach ($dto->preferences as $preference) {
            $this->preferenceRepository->updateByKey($preference->key, $preference->value);
        }
    }
}