<?php

namespace App\Repository;

use App\Entity\Translation;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class TranslationRepository extends AbstractRepository
{
    protected ?string $entity = Translation::class;
    protected ?string $alias = 't';
}