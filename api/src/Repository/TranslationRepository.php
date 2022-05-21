<?php

namespace App\Repository;

use App\Entity\Translation;

/**
 * Class TranslationRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Translation>
 *
 * @author  codememory
 */
class TranslationRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Translation::class;
}
