<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaPerformer;
use App\Repository\UserRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SetPerformersToMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SetPerformersToMultimediaService
{
    #[Required]
    public ?UserRepository $userRepository = null;

    public function set(array $performersEmail, Multimedia $multimedia): void
    {
        $performers = [];

        foreach ($performersEmail as $performerEmail) {
            $performer = $this->userRepository->getByEmail($performerEmail);

            if (null === $performer) {
                throw EntityNotFoundException::performer($performerEmail);
            }

            $multimediaPerformerEntity = new MultimediaPerformer();

            $multimediaPerformerEntity->setUser($performer);

            $performers[] = $multimediaPerformerEntity;
        }

        $multimedia->setPerformers($performers);
    }
}