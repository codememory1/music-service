<?php

namespace App\Command\Traits;

use App\Repository\AbstractRepository;
use function call_user_func;
use DateTimeImmutable;

trait DeleteByInvalidTtlTrait
{
    private function delete(AbstractRepository $entityRepository, ?callable $deleteCallback = null): void
    {
        foreach ($entityRepository->findAll() as $entity) {
            $of = $entity->getUpdatedAt() ?: $entity->getCreatedAt();
            $ofTimestamp = $of->getTimestamp();
            $nowTimestamp = (new DateTimeImmutable())->getTimestamp();

            if ($nowTimestamp > $ofTimestamp + $entity->getTtl()) {
                $this->em->remove($entity);
                $this->em->flush();

                if (null !== $deleteCallback) {
                    call_user_func($deleteCallback, $entity);
                }
            }
        }

        $this->em->clear();
    }
}