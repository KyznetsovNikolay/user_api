<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Service\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\User\Update\Handler as UpdateHandler;
use App\UseCase\User\Create\Handler as CreateHandler;

#[Route(name: 'api_')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $repository,
        private EntityManagerInterface $em,
        private ValidationService $validationService
    ) {}

    #[Route('/users', name: 'user_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $users = $this->repository->findAll();
        return $this->json($users);
    }

    #[Route('/users/{id}', name: 'get_user', methods: ['GET'])]
    public function one(Request $request): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $request->get('id')]);
        return $this->json($user);
    }

    #[Route('/users', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request, CreateHandler $handler): JsonResponse
    {
        try {
            $user = $handler->handle($request);
            if (count($errors = $this->validationService->validate($user)) != 0) {
                return $this->json($errors);
            }

            $this->em->persist($user);
            $this->em->flush();

            return $this->json($user);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }
    }

    #[Route('/users/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function deleteUser(Request $request): JsonResponse
    {
        $user = $this->repository->findOneBy(['id' => $request->get('id')]);
        $this->em->remove($user);
        $this->em->flush();

        return $this->json([
            'result' => 'succeed',
            'message' => 'User with id=' . $request->get('id') . ' was deleted'
        ]);
    }

    #[Route('/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(Request $request, UpdateHandler $handler): JsonResponse
    {
        try {
            $user = $handler->handle($request);
            if (count($errors = $this->validationService->validate($user)) != 0) {
                return $this->json($errors);
            }

            $this->em->persist($user);
            $this->em->flush();

            return $this->json($user);

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }
    }
}
