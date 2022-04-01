<?php

namespace App\Repository;

use App\Entity\SubscriptionPermissionName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SubscriptionPermissionNameRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method SubscriptionPermissionName|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriptionPermissionName|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriptionPermissionName[]    findAll()
 * @method SubscriptionPermissionName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionPermissionNameRepository extends ServiceEntityRepository
{

	/**
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{

		parent::__construct($registry, SubscriptionPermissionName::class);

	}

}
