<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\SortingEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use Codememory\Components\Database\Schema\Interfaces\SelectInterface;
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
     * @throws NotSelectedStatementException
     * @throws ReflectionException
     * @throws QueryNotGeneratedException
     */
    public function getColumns(string $table): array
    {

        /** @var SortingEntity[] $result */
        $result = $this->findBy(['table' => $table])->toEntity();

        if ([] != $result) {
            return json_decode($result[0]->getColumns());
        }

        return [];

    }

    /**
     * @param string $table
     * @param string $column
     *
     * @return bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function existColumn(string $table, string $column): bool
    {

        return in_array($column, $this->getColumns($table));

    }

    /**
     * @param SelectInterface $select
     * @param string          $table
     * @param array           $sortBy
     * @param string          $sortingType
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function addSorting(SelectInterface $select, string $table, array $sortBy, string $sortingType): void
    {

        $allowedColumns = $this->getColumns($table);

        // Filtering input columns by allowed
        $allowedColumnsForSorting = array_filter($sortBy, function (mixed $column) use ($allowedColumns) {
            return in_array($column, $allowedColumns);
        });

        if ([] !== $allowedColumnsForSorting) {
            // Create sort
            $order = $this->createQueryBuilder()->order($allowedColumnsForSorting, $sortingType);

            $select->orderBy($order);
        }

    }

}