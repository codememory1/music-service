<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\AlbumStatusEnum;
use App\Enum\MultimediaStatusEnum;
use Doctrine\ORM\Query\Expr\Join;

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
    protected ?string $entity = Multimedia::class;
    protected ?string $alias = 'm';

    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        $this->qb->leftJoin('m.metadata', 'md');
        $this->qb->leftJoin('m.auditions', 'a');
        $this->qb->groupBy('m, a');

        if (false !== $sortByTitle = $this->sortService->get('title')) {
            $orderBy['m.title'] = $this->getOrderType($sortByTitle);
        }

        if (false !== $sortByCreatedAt = $this->sortService->get('createdAt')) {
            $orderBy['m.createdAt'] = $this->getOrderType($sortByCreatedAt);
        }

        if (false !== $sortByDuration = $this->sortService->get('duration')) {
            $orderBy['md.duration'] = $sortByDuration;
        }

        if (false !== $sortByAuditions = $this->sortService->get('auditions')) {
            $orderBy['COUNT(a.id)'] = $this->getOrderType($sortByAuditions);
        }

        if (false !== $sortByLike = $this->sortService->get('like')) {
            $this->qb->leftJoin('m.ratings', 'r', Join::WITH, 'r.type = :ratingType');
            $this->qb->setParameter('ratingType', 'LIKE');

            $orderBy['COUNT(r.id)'] = $this->getOrderType($sortByLike);
        }

        if (false !== $filterByType = $this->filterService->get('type')) {
            $criteria['m.type'] = $filterByType;
        }

        return parent::findByCriteria($criteria, $orderBy);
    }

    public function findAnother(User $user): array
    {
        $this->qb->leftJoin('m.album', 'a');

        return $this->findByCriteria([
            'm.user' => $user,
            'm.status' => MultimediaStatusEnum::PUBLISHED->name,
            'a.status' => AlbumStatusEnum::PUBLISHED->name
        ]);
    }

    public function getByAlbum(?Album $album): ?Multimedia
    {
        return $this->findOneBy([
            'album' => $album
        ]);
    }

    public function findAllByUser(User $user): array
    {
        return $this->findByCriteria([
            'm.user' => $user
        ]);
    }
}
