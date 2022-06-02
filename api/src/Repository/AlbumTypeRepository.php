<?php

namespace App\Repository;

use App\Entity\AlbumType;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AlbumTypeRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<AlbumType>
 *
 * @author  Codememory
 */
class AlbumTypeRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = AlbumType::class;

    /**
     * @param Language|null $language
     *
     * @return array
     */
    public function all(?Language $language): array
    {
        $sortService = $this->sortService;
        $repository = $this;

        $orderBy = [];
        $callback = static function(QueryBuilder $qb, string $tableName) use ($repository, $sortService, $language, &$orderBy): void {
            if (false !== $sortByTitle = $sortService->get('title')) {
                $qb->leftJoin(Language::class, 'l', Join::WITH, $qb->expr()->eq(
                    'l.code',
                    ':lang_code'
                ));
                $qb->leftJoin(TranslationKey::class, 'tk', Join::WITH, $qb->expr()->eq(
                    'tk.key',
                    "${tableName}.titleTranslationKey"
                ));
                $qb->leftJoin(Translation::class, 't', Join::WITH, $qb->expr()->andX(
                    $qb->expr()->eq('t.language', 'l'),
                    $qb->expr()->eq('t.translationKey', 'tk')
                ));
                $qb->orderBy('t.translation', $repository->getOrderType($sortByTitle));
                $qb->setParameter('lang_code', $language->getCode());
            }
        };

        if (false !== $sortByKey = $sortService->get('key')) {
            $orderBy['key'] = $this->getOrderType($sortByKey);
        }

        return parent::findByCriteria([], $orderBy, $callback);
    }
}
