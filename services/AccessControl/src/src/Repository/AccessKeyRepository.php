<?php

namespace App\Repository;

use App\Entity\AccessKey;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class AccessKeyRepository extends AbstractRepository
{
    protected ?string $entity = AccessKey::class;
    protected ?string $alias = 'ak';

    public function findByHeader(string $microservice, string $key): ?AccessKey
    {
        return $this->findOneBy([
            'key' => $key,
            'microservice' => $microservice
        ]);
    }
}
