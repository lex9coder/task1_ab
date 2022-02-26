<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @return Author[] Returns an array of Author objects
     */
    public function findRandom(int $max_id=0)
    {
        return $this->createQueryBuilder('a')
            ->setFirstResult( rand(0, $max_id-1) )
            ->setMaxResults( rand(1, 3) )
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Author[] Returns an array of Author objects
     */
    public function findByName($name)
    {
        $qb = $this->createQueryBuilder('b');

        $i = 0;
        foreach ( explode(" ", $name) as $word) {
            $qb->andWhere('b.name LIKE :word'.$i);
            $qb->setParameter('word'.$i, '%'.$word.'%');
            $i++;
        }
        return $qb->getQuery()->getResult();
    }

    public function save(Author $author): void
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();
    }

    public function delete(Author $author): void
    {
        $this->getEntityManager()->remove($author);
        $this->getEntityManager()->flush();
    }

}
