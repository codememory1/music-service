<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\SortingEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Database\QueryBuilder\QueryBuilder;
use ReflectionException;

/**
 * Class SortingRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class SortingRepository extends AbstractEntityRepository
{

    /**
     * @param string $table
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getColumns(string $table): array
    {

        /** @var SortingEntity] $result */
        $result = $this->customFindBy(['table' => $table])->entity()->first();

        if (false != $result) {
            return $result->getColumns();
        }

        return [];

    }

    /**
     * @param string $table
     * @param string $column
     *
     * @return bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function existColumn(string $table, string $column): bool
    {

        return in_array($column, $this->getColumns($table));

    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $table
     * @param array        $sortBy
     * @param string       $sortingType
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function addSorting(QueryBuilder $queryBuilder, string $table, array $sortBy, string $sortingType): void
    {

        $allowedColumns = $this->getColumns($table);

        // Filtering input columns by allowed
        $allowedColumnsForSorting = array_filter($sortBy, function (mixed $column) use ($allowedColumns) {
            return in_array($column, $allowedColumns);
        });

        if ([] !== $allowedColumnsForSorting) {
            $queryBuilder->order($allowedColumnsForSorting, $sortingType);
        }

    }

}