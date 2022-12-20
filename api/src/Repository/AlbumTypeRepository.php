<?php

namespace App\Repository;

use App\Entity\AlbumType;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @template-extends AbstractRepository<AlbumType>
 */
final class AlbumTypeRepository extends AbstractRepository
{
    protected ?string $entity = AlbumType::class;
    protected ?string $alias = 'at';

    public function all(?Language $language): array
    {
        $orderBy = [];
        $qb = $this->getQueryBuilder();

        $qb->leftJoin(Language::class, 'l', Join::WITH, $qb->expr()->eq(
            'l.code',
            ':lang_code'
        ));

        if (false !== $sortByTitle = $this->sortService->get('title')) {
            $qb->leftJoin(TranslationKey::class, 'tk', Join::WITH, $qb->expr()->eq(
                'tk.key',
                'at.titleTranslationKey'
            ));
            $qb->leftJoin(Translation::class, 't', Join::WITH, $qb->expr()->andX(
                $qb->expr()->eq('t.language', 'l'),
                $qb->expr()->eq('t.translationKey', 'tk')
            ));
            $qb->orderBy('t.translation', $this->getOrderType($sortByTitle));
            $qb->setParameter('lang_code', $language->getCode());
        }

        if (false !== $sortByKey = $this->sortService->get('key')) {
            $orderBy['key'] = $this->getOrderType($sortByKey);
        }

        return parent::findByCriteria([], $orderBy);
    }
}
