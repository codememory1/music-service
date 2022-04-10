<?php

namespace App\Repository;

use App\Entity\User;
use App\Service\JwtTokenGenerator;
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
     * @var JwtTokenGenerator
     */
    private JwtTokenGenerator $jwtTokenGenerator;

    /**
     * @param ManagerRegistry   $registry
     * @param JwtTokenGenerator $jwtTokenGenerator
     */
    public function __construct(ManagerRegistry $registry, JwtTokenGenerator $jwtTokenGenerator)
    {
        parent::__construct($registry, User::class);

        $this->jwtTokenGenerator = $jwtTokenGenerator;
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
     * @return null|User
     */
    public function getArtist(int $id): ?User
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * @param string $refreshToken
     *
     * @return null|User
     */
    public function getUserByRefreshToken(string $refreshToken): ?User
    {
        $decodedToken = $this->jwtTokenGenerator->decode($refreshToken, 'JWT_REFRESH_PUBLIC_KEY');

        if (false === $decodedToken) {
            return null;
        }

        return $this->findOneBy(['email' => $decodedToken->email]);
    }
}
