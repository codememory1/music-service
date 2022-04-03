<?php

namespace App\Repository;

use App\Entity\ArtistSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ArtistSubscriberRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|ArtistSubscriber find($id, $lockMode = null, $lockVersion = null)
 * @method null|ArtistSubscriber findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistSubscriber[]    findAll()
 * @method ArtistSubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistSubscriberRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistSubscriber::class);
    }
}
