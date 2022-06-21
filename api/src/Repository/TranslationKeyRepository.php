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
    /**
     * @inheritDoc
     */
    protected ?string $entity = TranslationKey::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'tk';
}
