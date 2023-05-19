<?php

namespace App\Repository;

use App\Entity\PhoneCode;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class PhoneCodeRepository extends AbstractRepository
{
    protected ?string $entity = PhoneCode::class;
    protected ?string $alias = 'pc';
}
