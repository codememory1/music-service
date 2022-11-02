<?php

namespace App\Service\WebSocket\Components;

use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use Doctrine\ORM\EntityManagerInterface;

final class StreamRunningMultimediaComponent
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function createStreamRunningMultimedia(RunningMultimedia $runningMultimedia, UserSession $from, UserSession $to): StreamRunningMultimedia
    {
        $streamRunningMultimedia = new StreamRunningMultimedia();

        $streamRunningMultimedia->setRunningMultimedia($runningMultimedia);
        $streamRunningMultimedia->setFromUserSession($from);
        $streamRunningMultimedia->setToUserSession($to);
        $streamRunningMultimedia->pending();

        $this->em->persist($streamRunningMultimedia);
        $this->em->flush();

        return $streamRunningMultimedia;
    }
}