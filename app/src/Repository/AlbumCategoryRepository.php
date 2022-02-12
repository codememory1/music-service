<?php

namespace App\Repository;

use App\Entity\AlbumCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AlbumCategoryRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method AlbumCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumCategory[]    findAll()
 * @method AlbumCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumCategoryRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, AlbumCategory::class);

    }

}
