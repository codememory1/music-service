<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class LanguageRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|Language find($id, $lockMode = null, $lockVersion = null)
 * @method null|Language findOneBy(array $criteria, array $orderBy = null)
 * @method Language[]    findAll()
 * @method Language[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    /**
     * @param int $id
     *
     * @return bool|Language
     */
    public function existById(int $id): Language|bool
    {
        return $this->findOneBy(['id' => $id]) ?? false;
    }
}
