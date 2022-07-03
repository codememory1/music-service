<?php

namespace App\Command\Traits;

use App\Repository\AbstractRepository;
use function call_user_func;
use DateTimeImmutable;

/**
 * Trait DeleteByInvalidTtlTrait.
 *
 * @package App\Command\Traits
 *
 * @author  Codememory
 */
trait DeleteByInvalidTtlTrait
{
    private function delete(AbstractRepository $repository, ?callable $deleteCallback = null): void
    {
        foreach ($repository->findAll() as $entity) {
            $of = $entity->getUpdatedAt() ?: $entity->getCreatedAt();
            $of = $of->getTimestamp();
            $nowTimestamp = (new DateTimeImmutable())->getTimestamp();

            if ($nowTimestamp > $of + $entity->getTtl()) {
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