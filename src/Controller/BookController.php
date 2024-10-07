<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookCopy;
use App\Entity\Filter\BookFilter;
use App\Form\BookType;
use App\Form\Filter\BookFilterType;
use App\Repository\BookCopyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractController
{
    #[Route('/books', name: 'books_list', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): JsonResponse
    {
        $data = $request->query->all();

        $filter = new BookFilter();

        $filter->setTitle($data['title'] ?? null);
        $filter->setIsbn($data['isbn'] ?? null);
        $filter->setCategory($data['category'] ?? null);
        $filter->setAuthor($data['author'] ?? null);
        $filter->setPublicationYear(isset($data['publication_year']) ? new \DateTime($data['publication_year']) : null);

        $pagination = $paginator->paginate(
            $bookRepository->findByFilter($filter),
            $request->query->getInt('page', 1),
            10
        );

        return $this->json([
            'items' => $pagination->getItems(),
            'current_page' => $pagination->getCurrentPageNumber(),
            'total_items' => $pagination->getTotalItemCount(),
        ]);
    }

    #[Route('/books/{id}', name: 'books_show', methods: ['GET'])]
    public function show(int $id, BookRepository $bookRepository): JsonResponse
    {
        $book = $bookRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$book) {
            return $this->json('Livro não encontrado!', Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'data' => $book
        ]);
    }


    #[Route('/books', name: 'books_create', methods: ['POST'])]
    public function create(Request $request, BookRepository $bookRepository, UserRepository $userRepository, BookCopyRepository $bookCopyRepository): JsonResponse
    {
        $data = $request->request->all();

        $book = new Book();

        $book->setTitle($data['title']);
        $book->setIsbn($data['isbn']);
        $book->setCategory($data['category']);
        $book->setAuthor($data['author']);
        $book->setPublicationYear(new \DateTime($data['publication_year']));
        $book->setCreatedBy($this->getUser());

        $bookRepository->save($book);

        $bookCopy = new BookCopy();

        $bookCopy->setBook($book);
        $bookCopy->setOwner($this->getUser());

        $bookCopyRepository->save($bookCopy);

        return $this->json([
            'message' => 'Book created successfuly!'
        ], Response::HTTP_CREATED);
    }

    #[Route('/books/{id}', name: 'books_update', methods: ['PUT'])]
    public function update(int $id, Request $request, BookRepository $bookRepository): JsonResponse
    {
        $data = $request->request->all();
        $book = $bookRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$book) {
            return $this->json('Livro não encontrado!', Response::HTTP_NOT_FOUND);
        }

        $book->setTitle($data['title']);
        $book->setIsbn($data['isbn']);
        $book->setCategory($data['category']);
        $book->setAuthor($data['author']);
        $book->setPublicationYear(new \DateTime($data['publication_year']));
        $book->setUpdatedAt(new \DateTimeImmutable());

        $bookRepository->save($book);

        return $this->json([
            'message' => 'Book updated successfuly!'
        ], 201);
    }

    #[Route('/books/{id}', name: 'books_delete', methods: ['DELETE'])]
    public function delete(int $id, Request $request, BookRepository $bookRepository): JsonResponse
    {
        $book = $bookRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$book) {
            return $this->json('Livro não encontrado!', Response::HTTP_NOT_FOUND);
        }

        $bookRepository->delete($book);

        return $this->json([
            'message' => 'Book deleted successfuly!'
        ], 201);
    }
}
