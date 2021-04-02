<?php

namespace App\Controller;

use App\Controller\Handler\HandlerApiAddUser;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserController.
 *
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="get_users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): JsonResponse
    {
        $currentCustom = $this->getUser()->getId();
        $users = $userRepository->findBy(['fk_custom' => $currentCustom]);

        $UsersPagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        if (!$users) {
            return $response = $this->json('', Response::HTTP_NO_CONTENT, [], ['groups' => 'post:read']);
        }

        return $response = $this->json($UsersPagination, Response::HTTP_OK, [], ['groups' => 'post:read']);
    }

    /**
     * @Route("/users", name="add_user", methods={"POST"})
     */
    public function addUser(Request $request, HandlerApiAddUser $apiAddUser, SerializerInterface $serializer)
    {
        $currentCustom = $this->getUser();
        $jsonRecu = json_encode($request->getContent(), true);
        $post = $serializer->deserialize($jsonRecu, User::class, 'json', ['groups' => 'post:read']);
        dd($post);
        exit;
        $requestStatut = $apiAddUser->checkUserToAdd($post, $currentCustom);
        if ($requestStatut['statut']) {
            return $response = $this->json('Utilisateur ajouté avec succès', Response::HTTP_CREATED,
                [], []);
        } else {
            return $response = $this->json($requestStatut['errorMessage'], Response::HTTP_OK,
                [], []);
        }
    }

    /**
     * @Route("/user/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);
        $idCustom = $user->getFkCustom()->getId();
        $currentCustom = $this->getUser()->getId();

        if ($idCustom === $currentCustom) {
            $entityManager->remove($user);
            $entityManager->flush();

            return $response = $this->json('Utilisateur supprimé avec succès', Response::HTTP_OK, [], []);
        } else {
            return $response = $this->json('Vous ne pouvez pas supprimer cet utilisateur',
                Response::HTTP_NO_CONTENT,
                [], []);
        }
    }

    /**
     * @Route("/user/{id}", name="get_user", methods={"GET"})
     */
    public function GetOneUser(UserRepository $userRepository, $id): JsonResponse
    {
        $users = $userRepository->find($id);
        $idCustom = $users->getFkCustom()->getId();
        $currentCustom = $this->getUser()->getId();

        if (!$users) {
            return $response = $this->json('', Response::HTTP_NO_CONTENT, [], ['groups' => 'post:read']);
        }

        if ($idCustom === $currentCustom) {
            return $response = $this->json($users, Response::HTTP_OK, [], ['groups' => 'post:read']);
        } else {
            return $response = $this->json(null, Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
                [], []);
        }
    }
}
