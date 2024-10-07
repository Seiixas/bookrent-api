<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

#[Route('/users', name: 'user')]
class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function register(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = $request->request->all();

        $user = new User();

        $user->setEmail($data['email']);
        $user->setFullName($data['username']);
        $user->setCourse($data['course']);
        $user->setInstitution($data['institution']);

        $hashedPassword = $passwordHasher
            ->hashPassword($user, $data['password']);

        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'User created successfuly!'
        ], Response::HTTP_CREATED);
    }

    #[Route('/', name: 'users', methods: ['GET'])]
    public function list(UserRepository $userRepository): JsonResponse
    {
        return $this->json([
            'data' => $userRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'users_show', methods: ['GET'])]
    public function show(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository
            ->find($id);

        if (!$user) {
            return $this->json('Usuário não encontrado!', Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'data' => $user
        ]);
    }
}
