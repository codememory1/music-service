<?php

namespace App\Repository;

use App\Entity\PlaylistDirectory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PlaylistDirectoryRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method PlaylistDirectory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaylistDirectory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistDirectory[]    findAll()
 * @method PlaylistDirectory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistDirectoryRepository extends ServiceEntityRepository
{

	/**
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{

		parent::__construct($registry, PlaylistDirectory::class);

	}

}
