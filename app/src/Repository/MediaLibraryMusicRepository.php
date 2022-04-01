<?php

namespace App\Repository;

use App\Entity\MediaLibraryMusic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MediaLibraryMusicRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method MediaLibraryMusic|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaLibraryMusic|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaLibraryMusic[]    findAll()
 * @method MediaLibraryMusic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaLibraryMusicRepository extends ServiceEntityRepository
{

	/**
	 * @param ManagerRegistry $registry
	 */
	public function __construct(ManagerRegistry $registry)
	{

		parent::__construct($registry, MediaLibraryMusic::class);

	}

}
