<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaPerformer;
use App\Repository\UserRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AddMultimediaPerformersService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class AddMultimediaPerformersService
{
    #[Required]
    public ?UserRepository $userRepository = null;

    /**
     * @param array      $performers
     * @param Multimedia $multimedia
     *
     * @return void
     */
    public function make(array $performers, Multimedia $multimedia): void
    {
        foreach ($performers as $performerEmail) {
            $performer = $this->userRepository->getByEmail($performerEmail);

            if (null === $performer) {
                throw EntityNotFoundException::performer($performerEmail);
            }

            $multimediaPerformerEntity = new MultimediaPerformer();

            $multimediaPerformerEntity->setMultimedia($multimedia);
            $multimediaPerformerEntity->setUser($performer);

            $multimedia->addPerformer($multimediaPerformerEntity);
        }
    }
}