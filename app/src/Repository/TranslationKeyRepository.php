<?php

namespace App\Repository;

use App\Entity\TranslationKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TranslationKeyRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|TranslationKey find($id, $lockMode = null, $lockVersion = null)
 * @method null|TranslationKey findOneBy(array $criteria, array $orderBy = null)
 * @method TranslationKey[]    findAll()
 * @method TranslationKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationKeyRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TranslationKey::class);
    }
}
