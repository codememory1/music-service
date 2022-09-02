<?php

namespace App\Repository;

use App\Entity\MultimediaCategory;

/**
 * @template-extends AbstractRepository<MultimediaCategory>
 */
final class MultimediaCategoryRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaCategory::class;
    protected ?string $alias = 'mc';

    public function findByTitle(string $titleTranslationKey): ?MultimediaCategory
    {
        return $this->findOneBy(['titleTranslationKey' => $titleTranslationKey]);
    }
}
