<?php

namespace App\Repository;

use App\Entity\BookCopy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookCopy>
 */
class BookCopyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCopy::class);
    }

    public function save(BookCopy $bookCopy)
    {
        $em = $this->getEntityManager();
        
        $em->persist($bookCopy);
        $em->flush();
    }

    public function delete(BookCopy $bookCopy)
    {
        // $bookCopy->setEnabled(false);
        // $bookCopy->setUpdatedAt(new \DateTimeImmutable());
        
        $this->save($bookCopy);
    }

    //    /**
    //     * @return BookCopy[] Returns an array of BookCopy objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BookCopy
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
