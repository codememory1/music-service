<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Entities\LanguageTranslationEntity;
use App\Orm\Entities\TranslationKeyEntity;
use Codememory\Components\Database\Orm\QueryBuilder\Answer\ResultTo;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class LanguageTranslationRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class LanguageTranslationRepository extends AbstractEntityRepository
{

    /**
     * @param string $lang
     *
     * @return array
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    public function getTranslations(string $lang): array
    {

        return $this->getTranslationsWithColumns($lang, [
            'original_lang_id'            => 'l.id',
            'original_translation_key_id' => 'tk.id',
            'lt.*',
            'l.lang',
            'tk.key'
        ])->entity()->all();

    }

    /**
     * @param string $lang
     * @param array  $columns
     *
     * @return ResultTo
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getTranslationsWithColumns(string $lang, array $columns): ResultTo
    {

        $qb = $this->createQueryBuilder();

        $qb
            ->setParameter('lang', $lang)
            ->select($columns)
            ->from($this->getEntityData()->getTableName(), 'lt')
            ->innerJoin(
                [
                    'l' => $this->getEntityData(LanguageEntity::class)->getTableName()
                ],
                $qb->joinComparison('l.lang', ':lang')
            )
            ->innerJoin(
                [
                    'tk' => $this->getEntityData(TranslationKeyEntity::class)->getTableName()
                ],
                $qb->joinComparison('lt.translation_key_id', 'tk.id')
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('lt.lang_id', '=', 'l.id')
                )
            );

        return $qb->generateTo();

    }

    /**
     * @param string $lang
     * @param string $key
     *
     * @return LanguageTranslationEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getTranslation(string $lang, string $key): LanguageTranslationEntity|bool
    {

        $qb = $this->createQueryBuilder();

        $qb
            ->setParameter('lang', $lang)
            ->setParameter('key', $key)
            ->select()
            ->from($this->getEntityData(TranslationKeyEntity::class)->getTableName(), 'tk')
            ->innerJoin(
                [
                    'l' => $this->getEntityData(LanguageEntity::class)->getTableName()
                ],
                $qb->joinComparison('l.lang', ':lang')
            )
            ->innerJoin(
                [
                    'lt' => $this->getEntityData(LanguageTranslationEntity::class)->getTableName()
                ],
                $qb->joinComparison('lt.translation_key_id', 'tk.id')
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('tk.key', '=', ':key'),
                    $qb->expression()->condition('lt.lang_id', '=', 'l.id'),
                )
            );

        return $qb->generateTo()->entity()->first();

    }

}