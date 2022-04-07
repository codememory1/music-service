<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|User find($id, $lockMode = null, $lockVersion = null)
 * @method null|User findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $login
     *
     * @throws NonUniqueResultException
     *
     * @return null|User
     */
    public function findByLogin(string $login): ?User
    {
        return $this->createQueryBuilder('u')
            ->orWhere('u.email = :login')
            ->orWhere('u.username = :login')
            ->setParameter('login', $login)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $id
     *
     * @return User|null
     */
    public function getArtist(int $id): ?User
    {
        return $this->findOneBy(['id' => $id]);
    }
}
