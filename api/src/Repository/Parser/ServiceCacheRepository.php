<?php

namespace App\Repository\Parser;

use App\Entity\Parser\ServiceCache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

/**
 * @extends ServiceEntityRepository<ServiceCache>
 *
 * @method ServiceCache|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceCache|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceCache[]    findAll()
 * @method ServiceCache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceCacheRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(ServiceCache::class));
    }

    public function findByLink(string $link): ?ServiceCache
    {
        return $this->findOneBy(['link' => $link]);
    }
}
