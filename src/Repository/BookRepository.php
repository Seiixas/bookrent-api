<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Filter\BookFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $book)
    {
        $em = $this->getEntityManager();
        
        $em->persist($book);
        $em->flush();
    }

    public function delete(Book $book)
    {
        $book->setEnabled(false);
        $book->setUpdatedAt(new \DateTimeImmutable());
        
        $this->save($book);
    }

    public function findByFilter(BookFilter $filter)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        $queryBuilder->andWhere('b.enabled = true');

        if ($filter->getIsbn()) {
            $queryBuilder->andWhere('b.isbn LIKE :isbn')
                ->setParameter('isbn', "%".$filter->getIsbn()."%");
        }

        if ($filter->getTitle()) {
            $queryBuilder->andWhere('b.title LIKE :title')
                ->setParameter('title', "%".$filter->getTitle()."%");
        }

        if ($filter->getCategory()) {
            $queryBuilder->andWhere('b.category LIKE :category')
                ->setParameter('category', "%".$filter->getCategory()."%");
        }

        if ($filter->getPublicationYear()) {
            $queryBuilder->andWhere('b.publication_year = :publication_year')
                ->setParameter('publication_year', $filter->getPublicationYear()->format('Y-m-d'));
        }

        return $queryBuilder->getQuery();
    }

//    /**
//     * @return Book[] Returns an array of Book objects
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

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
