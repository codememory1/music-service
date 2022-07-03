<?php

namespace App\Repository;

use App\Entity\TranslationKey;

/**
 * Class TranslationKeyRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<TranslationKey>
 *
 * @author  codememory
 */
class TranslationKeyRepository extends AbstractRepository
{
    protected ?string $entity = TranslationKey::class;
    protected ?string $alias = 'tk';
}
