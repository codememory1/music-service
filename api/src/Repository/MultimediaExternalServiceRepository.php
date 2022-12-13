<?php

namespace App\Repository;

use App\Entity\MultimediaExternalService;

/**
 * @template-extends AbstractRepository<MultimediaExternalService>
 */
final class MultimediaExternalServiceRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaExternalService::class;
    protected ?string $alias = 'mes';
}
