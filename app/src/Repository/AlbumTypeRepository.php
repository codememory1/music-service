<?php

namespace App\Repository;

use App\Entity\AlbumType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AlbumTypeRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method AlbumType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumType[]    findAll()
 * @method AlbumType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumTypeRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, AlbumType::class);

    }

}
