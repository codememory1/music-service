<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Entity\User;

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
     * @inheritDoc
     */
    protected ?string $alias = 'm';

    /**
     * @inheritDoc
     */
    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        if (false !== $sortByTitle = $this->sortService->get('title')) {
            $orderBy['m.title'] = $this->getOrderType($sortByTitle);
        }

        if (false !== $sortByCreatedAt = $this->sortService->get('createdAt')) {
            $orderBy['m.createdAt'] = $this->getOrderType($sortByCreatedAt);
        }

        if (false !== $filterByType = $this->filterService->get('type')) {
            $criteria['m.type'] = $filterByType;
        }

        return parent::findByCriteria($criteria, $orderBy);
    }

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

    /**
     * @param User $user
     *
     * @return array
     */
    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria([
            'm.user' => $user
        ]);
    }
}
