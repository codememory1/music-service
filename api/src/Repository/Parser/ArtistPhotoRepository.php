<?php

namespace App\Repository\Parser;

use App\Entity\Parser\ArtistPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtistPhoto>
 *
 * @method null|ArtistPhoto find($id, $lockMode = null, $lockVersion = null)
 * @method null|ArtistPhoto findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistPhoto[]    findAll()
 * @method ArtistPhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistPhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistPhoto::class);
    }
}
