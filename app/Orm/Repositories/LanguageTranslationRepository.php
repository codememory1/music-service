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
            'original_lang_id' => 'l.id',
            'lt.*',
            'l.lang_code'
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
            ->setParameter('lang_code', $lang)
            ->select($columns)
            ->from($this->getEntityData()->getTableName(), 'lt')
            ->innerJoin(
                [
                    'l' => $this->getEntityData(LanguageEntity::class)->getTableName()
                ],
                $qb->joinComparison('l.lang_code', ':lang_code')
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
            ->setParameter('lang_code', $lang)
            ->setParameter('key', $key)
            ->select()
            ->from($this->getEntityData()->getTableName(), 'lt')
            ->innerJoin(
                [
                    'l' => $this->getEntityData(LanguageEntity::class)->getTableName()
                ],
                $qb->joinComparison('l.lang_code', ':lang_code')
            )
            ->where(
                $qb->expression()->exprAnd(
                    $qb->expression()->condition('lt.lang_id', '=', 'l.id'),
                    $qb->expression()->condition('lt.key', '=', ':key')
                )
            );

        return $qb->generateTo()->entity()->first();

    }

}