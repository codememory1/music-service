<?php

namespace App\Repository;

use App\Entity\Language;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class LanguageRepository extends AbstractRepository
{
    protected ?string $entity = Language::class;
    protected ?string $alias = 'l';
}
