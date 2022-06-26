<?php

namespace App\Repository;

use App\Entity\Language;

/**
 * Class LanguageRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Language>
 *
 * @author Codememory
 */
class LanguageRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Language::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'l';

    /**
     * @inheritDoc
     */
    public function findByCriteria(array $criteria, array $orderBy = []): array
    {
        if (false !== $sortByCode = $this->sortService->get('code')) {
            $orderBy['l.code'] = $this->getOrderType($sortByCode);
        }

        if (false !== $sortByTitle = $this->sortService->get('title')) {
            $orderBy['l.originalTitle'] = $this->getOrderType($sortByTitle);
        }

        return parent::findByCriteria([], $orderBy);
    }
}
