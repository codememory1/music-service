<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\TranslationKeyEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class TranslationKeyRepository
 *
 * @package App\Orm\Repositories
 *
 * @author Danil
 */
class TranslationKeyRepository extends AbstractEntityRepository
{

    /**
     * @param string $key
     *
     * @return TranslationKeyEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getTranslationKey(string $key): TranslationKeyEntity|bool
    {

        return $this->customFindBy(['key' => $key])->entity()->first();

    }

    /**
     * @param array  $by
     * @param string $expr
     *
     * @return TranslationKeyEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by, string $expr = 'and'): TranslationKeyEntity|bool
    {

        return $this->customFindBy($by, $expr)->entity()->first();

    }

}