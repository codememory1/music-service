<?php

namespace App\Repository;

use App\Entity\StreamRunningMultimedia;

/**
 * Class StreamRunningMultimediaRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<StreamRunningMultimedia>
 *
 * @author  Codememory
 */
class StreamRunningMultimediaRepository extends AbstractRepository
{
    protected ?string $entity = StreamRunningMultimedia::class;
    protected ?string $alias = 'srm';
}
