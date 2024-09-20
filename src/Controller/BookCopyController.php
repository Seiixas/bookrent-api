<?php

namespace App\Controller;

use App\Entity\BookCopy;
use App\Repository\BookCopyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookCopyController extends AbstractController
{
    #[Route('/copies', name: 'copies', methods: ['GET'])]
    public function index(Request $request, BookCopyRepository $bookCopyRepository, PaginatorInterface $paginator): JsonResponse
    {   
        $pagination = $paginator->paginate(
            $bookCopyRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->json([
            'items' => $pagination->getItems(),
            'current_page' => $pagination->getCurrentPageNumber(),
            'total_items' => $pagination->getTotalItemCount(),
        ], Response::HTTP_OK,['groups' => ['default']]);
    }


    #[Route('/copies/{id}', name: 'copies_show', methods: ['GET'])]
    public function show(int $id, BookCopyRepository $bookCopyRepository): JsonResponse
    {
        $rent = $bookCopyRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$rent) {
            return $this->json('Aluguel não encontrado!', Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'data' => $rent
        ]);
    }


    #[Route('/copies', name: 'copies_create', methods: ['POST'])]
    public function create(Request $request, BookCopyRepository $bookCopyRepository): JsonResponse
    {
        $data = $request->request->all();

        $rent = new BookCopy();

        $rent->setBook($data['book']);
        $rent->setOwner($data['owner']);

        $bookCopyRepository->save($rent);

        return $this->json([
            'message' => 'Rent created successfuly!'
        ], Response::HTTP_CREATED);
    }

    // #[Route('/copies/{id}', name: 'copies_update', methods: ['PUT'])]
    // public function update(int $id, Request $request, BookCopyRepository $bookCopyRepository): JsonResponse
    // {
    //     $data = $request->request->all();
    //     $rent = $bookCopyRepository
    //         ->findOneBy(['id' => $id, 'enabled' => true]);

    //     if (!$rent) {
    //         return $this->json('Aluguel não encontrado!', Response::HTTP_NOT_FOUND);
    //     }

    //     $rent->setLenderUser($data['lender_user']);
    //     $rent->setReceptorUser($data['receptor_user']);
    //     $rent->setRentDate(new \DateTime($data['rent_date']));
    //     $rent->setReturnDate(new \DateTime($data['return_date']));
    //     $rent->setBookCopy($data['book_copy']);
    //     $rent->setUpdatedAt(new \DateTimeImmutable());

    //     $rentRepository->save($rent);

    //     return $this->json([
    //         'message' => 'Book updated successfuly!'
    //     ], 201);
    // }

    // #[Route('/rents/{id}', name: 'rents_delete', methods: ['DELETE'])]
    // public function delete(int $id, Request $request, RentRepository $rentRepository): JsonResponse
    // {
    //     $rent = $rentRepository
    //         ->findOneBy(['id' => $id, 'enabled' => true]);

    //     if (!$rent) {
    //         return $this->json('Aluguel não encontrado!', Response::HTTP_NOT_FOUND);
    //     }

    //     $rentRepository->delete($rent);

    //     return $this->json([
    //         'message' => 'Rent deleted successfuly!'
    //     ], 201);
    // }
}
