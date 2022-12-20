<?php

namespace App\Repository;

use App\Entity\Playlist;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<Playlist>
 */
final class PlaylistRepository extends AbstractRepository
{
    protected ?string $entity = Playlist::class;
    protected ?string $alias = 'p';

    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        $this->qb->leftJoin('p.multimedia', 'm');

        if (false !== $sortByTitle = $this->sortService->get('title')) {
            $orderBy['p.title'] = $this->getOrderType($sortByTitle);
        }

        if (false !== $sortByCreatedAt = $this->sortService->get('createdBy')) {
            $orderBy['p.createdBy'] = $this->getOrderType($sortByCreatedAt);
        }

        if (false !== $sortByNumberMultimedia = $this->sortService->get('numberMultimedia')) {
            $orderBy['COUNT(m.id)'] = $this->getOrderType($sortByNumberMultimedia);
        }

        if (false !== $filterByTitle = $this->filterService->get('title')) {
            $this->qb->andWhere($this->qb->expr()->like('tk.key', ':key'));
            $this->qb->setParameter('key', "${$filterByTitle}@%");
        }

        return parent::findByCriteria($criteria, $orderBy);
    }

    public function findByUser(User $user): array
    {
        return $this->findByCriteria([
            'p.mediaLibrary' => $user->getMediaLibrary()
        ]);
    }
}
