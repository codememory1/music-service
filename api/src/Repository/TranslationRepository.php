<?php

namespace App\Repository;

use App\Entity\Translation;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TranslationRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Translation>
 *
 * @author  codememory
 */
class TranslationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Translation::class;

    /**
     * @inheritDoc
     */
    public function findByCriteria(array $criteria, array $orderBy = [], ?callable $callback = null): array
    {
        $filterService = $this->filterService;

        $callback = static function(QueryBuilder $qb, string $tableName) use ($filterService): void {
            $qb->leftJoin("${tableName}.translationKey", 'tk');

            if (false !== $filterByGroup = $filterService->get('group')) {
                $qb->andWhere($qb->expr()->like('tk.key', ':key'));
                $qb->setParameter('key', "${filterByGroup}@%");
            }

            if (false !== $filterByKey = $filterService->get('key')) {
                $qb->andWhere('tk.key = :key');
                $qb->setParameter('key', $filterByKey);
            }
        };

        return parent::findByCriteria($criteria, [], $callback);
    }
}
