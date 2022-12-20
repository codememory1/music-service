<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;

/**
 * @template-extends AbstractRepository<Translation>
 */
final class TranslationRepository extends AbstractRepository
{
    protected ?string $entity = Translation::class;
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

    public function findAllByLanguage(Language $language): array
    {
        return $this->findByCriteria([
            't.language' => $language
        ]);
    }

    public function findTranslation(Language $language, TranslationKey $translationKey): ?Translation
    {
        return $this->findOneBy([
            'language' => $language,
            'translationKey' => $translationKey
        ]);
    }
}
