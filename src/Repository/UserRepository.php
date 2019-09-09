<?php

    namespace App\Repository;

    use App\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use phpDocumentor\Reflection\Types\Integer;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    /**
     * @method User|null find($id, $lockMode = null, $lockVersion = null)
     * @method User|null findOneBy(array $criteria, array $orderBy = null)
     * @method User[]    findAll()
     * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function findAllUsernameAlphabetical()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return User[]
     */
    public function findAllMatching(string $query, int $limit = null)
    {
        if (!$limit) {
            $limit = 5;
        }

        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
