<?php

namespace App\Controller;

use App\Entity\BookCopy;
use App\Entity\Rent;
use App\Repository\RentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RentController extends AbstractController
{
    #[Route('/rents', name: 'rents', methods: ['GET'])]
    public function index(Request $request, RentRepository $rentRepository, PaginatorInterface $paginator): JsonResponse
    {
        $pagination = $paginator->paginate(
            $rentRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->json([
            'items' => $pagination->getItems(),
            'current_page' => $pagination->getCurrentPageNumber(),
            'total_items' => $pagination->getTotalItemCount(),
        ]);
    }

    #[Route('/rents/{id}', name: 'rents_show', methods: ['GET'])]
    public function show(int $id, RentRepository $rentRepository): JsonResponse
    {
        $rent = $rentRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$rent) {
            return $this->json('Aluguel não encontrado!', Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'data' => $rent
        ]);
    }


    #[Route('/rents/{bookCopy}', name: 'rents_create', methods: ['POST'])]
    public function create(Request $request, BookCopy $bookCopy, RentRepository $rentRepository): JsonResponse
    {
        if ($bookCopy->isRented()) {
            return $this->json('Não é possível alugar esse livro!', Response::HTTP_NOT_FOUND);
        }

        $data = $request->request->all();

        $rent = new Rent();

        $rent->setLenderUser($bookCopy->getOwner());
        $rent->setReceptorUser($this->getUser());
        $rent->setRentDate(new \DateTime('now'));
        $rent->setReturnDate(new \DateTime($data['return_date']));
        $rent->setBookCopy($bookCopy);

        $bookCopy->setRented(true);

        $rentRepository->save($rent);

        return $this->json([
            'message' => 'Rent created successfuly!'
        ], Response::HTTP_CREATED);
    }

    // #[Route('/rents/{id}', name: 'rents_update', methods: ['PUT'])]
    // public function update(int $id, Request $request, RentRepository $rentRepository): JsonResponse
    // {
    //     $data = $request->request->all();
    //     $rent = $rentRepository
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

    #[Route('/rents/{id}', name: 'rents_delete', methods: ['DELETE'])]
    public function delete(int $id, Request $request, RentRepository $rentRepository): JsonResponse
    {
        $rent = $rentRepository
            ->findOneBy(['id' => $id, 'enabled' => true]);

        if (!$rent) {
            return $this->json('Aluguel não encontrado!', Response::HTTP_NOT_FOUND);
        }

        $rentRepository->delete($rent);

        return $this->json([
            'message' => 'Rent deleted successfuly!'
        ], 201);
    }
}
