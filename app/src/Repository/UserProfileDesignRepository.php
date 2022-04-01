<?php

namespace App\Repository;

use App\Entity\UserProfileDesign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserProfileDesignRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method UserProfileDesign|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfileDesign|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfileDesign[]    findAll()
 * @method UserProfileDesign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfileDesignRepository extends ServiceEntityRepository
{

	/**
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{

		parent::__construct($registry, UserProfileDesign::class);

	}

}
