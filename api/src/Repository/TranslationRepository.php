<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Translation;

/**
 * Class TranslationRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Translation>
 *
 * @author  Codememory
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
    protected ?string $alias = 't';

    /**
     * @inheritDoc
     */
    protected function findByCriteria(array $criteria, array $orderBy = []): array
    {
        $qb = $this->getQueryBuilder();

        $qb->leftJoin('t.translationKey', 'tk');

        if (false !== $filterByGroup = $this->filterService->get('group')) {
            $qb->andWhere($qb->expr()->like('tk.key', ':key'));
            $qb->setParameter('key', "${filterByGroup}@%");
        }

        if (false !== $filterByKey = $this->filterService->get('key')) {
            $qb->andWhere('tk.key = :key');
            $qb->setParameter('key', $filterByKey);
        }

        return parent::findByCriteria($criteria, []);
    }

    /**
     * @param Language $language
     *
     * @return array
     */
    public function findAllByLanguage(Language $language): array
    {
        return $this->findByCriteria([
            't.language' => $language
        ]);
    }
}
