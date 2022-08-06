<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;

/**
 * Class RunningMultimediaRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<RunningMultimedia>
 *
 * @author  Codememory
 */
class RunningMultimediaRepository extends AbstractRepository
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
