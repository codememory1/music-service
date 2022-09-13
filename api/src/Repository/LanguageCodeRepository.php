<?php

namespace App\Repository;

use App\Entity\LanguageCode;

/**
 * @template-extends AbstractRepository<LanguageCode>
 */
final class LanguageCodeRepository extends AbstractRepository
{
    protected ?string $entity = LanguageCode::class;
    protected ?string $alias = 'lc';

    public function findByCode(string $code): ?LanguageCode
    {
        $this->qb->where($this->qb->expr()->orX(
            $this->qb->expr()->eq('lc.twoLetterCode', ':code'),
            $this->qb->expr()->eq('lc.threeLetterCode', ':code')
        ));
        $this->qb->setParameter('code', $code);

        return $this->qb->getQuery()->setMaxResults(1)->getResult()[0] ?? null;
    }
}
