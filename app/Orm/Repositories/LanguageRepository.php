<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\LanguageEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class LanguageRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class LanguageRepository extends AbstractEntityRepository
{

    /**
     * @param string $lang
     *
     * @return LanguageEntity|bool
     * @throws StatementNotSelectedException
     * @throws ReflectionException
     */
    public function getLang(string $lang): LanguageEntity|bool
    {

        return $this->customFindBy(['lang_code' => $lang])->entity()->first();

    }

    /**
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getAllLangs(): array
    {

        return $this->customFindAll()->entity()->all();

    }

}