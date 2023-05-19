<?php

namespace App\Repository;

use App\Entity\TranslationKey;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class TranslationKeyRepository extends AbstractRepository
{
    protected ?string $entity = TranslationKey::class;
    protected ?string $alias = 'tk';
}
