<?php

namespace App\Service\Multimedia;

use App\DTO\MultimediaDTO;
use App\Entity\Multimedia;
use App\Enum\EventEnum;
use App\Event\SaveMultimediaEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SaveMultimediaService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param Multimedia    $multimedia
     *
     * @return void
     */
    public function make(MultimediaDTO $multimediaDTO, Multimedia $multimedia): void
    {
        $this->eventDispatcher->dispatch(
            new SaveMultimediaEvent($multimediaDTO, $multimedia),
            EventEnum::BEFORE_SAVE_MULTIMEDIA->value
        );

        if (null === $multimedia->getId()) {
            $this->em->persist($multimedia);
        }

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new SaveMultimediaEvent($multimediaDTO, $multimedia),
            EventEnum::AFTER_SAVE_MULTIMEDIA->value
        );
    }
}