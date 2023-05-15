<?php

namespace App\Repository;

use App\Entity\Preference;
use App\Enum\PreferenceKey;
use Codememory\ApiBundle\Repository\AbstractRepository;

final class PreferenceRepository extends AbstractRepository
{
    protected ?string $entity = Preference::class;
    protected ?string $alias = 'p';

    public function findByKey(PreferenceKey $key): ?Preference
    {
        return $this->findOneBy(['key' => $key->name]);
    }

    public function updateByKey(PreferenceKey $key, mixed $value): void
    {
        $qb = $this->createQB();

        $qb
            ->update($this->entity, $this->alias)
            ->set('p.value', ':value')
            ->where(
                $qb->expr()->eq('p.key', ':key')
            );

        $qb->setParameter('key', $key->name);
        $qb->setParameter('value', is_array($value) ? json_encode($value) : $value);

        $qb->getQuery()->execute();
    }
}
