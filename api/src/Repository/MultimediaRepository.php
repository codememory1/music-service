<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\Multimedia;

/**
 * Class MultimediaRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Multimedia>
 *
 * @author  Codememory
 */
class MultimediaRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Multimedia::class;

    /**
     * @param null|Album $album
     *
     * @return null|Multimedia
     */
    public function getByAlbum(?Album $album): ?Multimedia
    {
        return $this->findOneBy([
            'album' => $album
        ]);
    }
}
