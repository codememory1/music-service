<?php

namespace Codememory\MicroserviceHttpClientBundle\EventListener\CacheClear;

use Codememory\MicroserviceHttpClientBundle\Interface\CacheInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;

final class HttpCacheClearEventListener
{
    public function __construct(
        private readonly CacheInterface $cache
    ) {
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        if ($event->getCommand()->getName() === 'cache:clear') {
            $this->cache->deleteAll();
        }
    }
}