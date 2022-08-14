<?php

namespace App\Repository;

use App\Entity\TranslationKey;

/**
 * @template-extends AbstractRepository<TranslationKey>
 */
final class TranslationKeyRepository extends AbstractRepository
{
    protected ?string $entity = TranslationKey::class;
    protected ?string $alias = 'tk';
    
    public function findByKey(string $key): ?TranslationKey
    {
        return $this->findOneBy(['key' => $key]);
    }
}
