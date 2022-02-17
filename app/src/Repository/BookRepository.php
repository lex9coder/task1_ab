<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $book): void
    {
        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();
    }

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
}
