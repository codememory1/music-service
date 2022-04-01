<?php

namespace App\Repository;

use App\Entity\MusicRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MusicRatingRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method MusicRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicRating[]    findAll()
 * @method MusicRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicRatingRepository extends ServiceEntityRepository
{

	/**
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{

		parent::__construct($registry, MusicRating::class);

	}

}
