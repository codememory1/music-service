<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
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
     * @return User|null
     * @throws NonUniqueResultException
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

}
