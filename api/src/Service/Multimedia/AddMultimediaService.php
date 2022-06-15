<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\User;
use App\Enum\MultimediaStatusEnum;
use App\Repository\UserRepository;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class AddMultimediaService extends AbstractService
{
    #[Required]
    public ?UserRepository $userRepository = null;

    public function make(MultimediaDTO $multimediaDTO, User $toUser): JsonResponse
    {
        if (false === $this->validate($multimediaDTO)) {
            return $this->validator->getResponse();
        }

        $multimediaEntity = $multimediaDTO->getEntity();

        $multimediaEntity->setUser($toUser);
        $multimediaEntity->setStatus(MultimediaStatusEnum::MODERATION);

        foreach ($multimediaDTO->performers as $performerEmail) {
            $performer = $this->userRepository->getByEmail($performerEmail);

            if (null === $performer) {
                // TODO: throw Исполнитель не найден
            }
        }

        // TODO: Слушатель - проверка что в альбом можно закгрузить более одной мультимедии

        // TODO: Слушатель - проверка mime-type файла взависимости от $multimediaDTO->type

        // TODO: Слушатель - Проверка корректности субтитров

        // TODO: Добавление мультимедии
    }
}