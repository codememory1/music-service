<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;

/**
 * @template-extends AbstractRepository<RunningMultimedia>
 */
final class RunningMultimediaRepository extends AbstractRepository
{
    protected ?string $entity = RunningMultimedia::class;
    protected ?string $alias = 'rm';

    public function findByMultimedia(?Multimedia $multimedia): ?RunningMultimedia
    {
        return $this->findOneBy([
            'multimedia' => $multimedia
        ]);
    }
}
