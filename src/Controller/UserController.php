<?php

namespace App\Controller;

use App\Controller\Handler\HandlerApiAddUser;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
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
     * @SWG\Response(
     *     response=200,
     *     description="Returns the users of your organisation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="table",
     *     in="query",
     *     type="string",
     *     description="The name of table"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
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

        $response = $this->json($UsersPagination, Response::HTTP_OK, [], ['groups' => 'post:read']);
        $response->setPublic();
        $response->setMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/users", name="add_user", methods={"POST"})
     * @SWG\Response(
     *     response=200,
     *     description="Add an user in your organisation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The collection page number"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @return JsonResponse
     */
    public function addUser(Request $request, HandlerApiAddUser $apiAddUser, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $currentCustom = $this->getUser();
        $jsonRecu = $request->getContent();
        $postUser = $serializer->deserialize($jsonRecu, User::class, 'json');

        $requestStatut = $apiAddUser->checkUserToAdd($postUser, $currentCustom, $entityManager);
        if ($requestStatut['statut']) {
            return $response = $this->json('Utilisateur ajouté avec succès', Response::HTTP_CREATED,
                [], []);
        } else {
            return $response = $this->json($requestStatut['errorMessage'], Response::HTTP_PRECONDITION_FAILED,
                [], []);
        }
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="delete an user in your organisation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="The id of user"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param $id
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
     * @Route("/users/{id}", name="get_user", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="get an user in your organisation by id",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="The id of user"
     * )
     *
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param $id
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
            $response = $this->json($users, Response::HTTP_OK, [], ['groups' => 'post:read']);
            $response->setPublic();
            $response->setMaxAge(3600);
            $response->headers->addCacheControlDirective('must-revalidate', true);

            return $response;
        } else {
            return $response = $this->json(null, Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
                [], []);
        }
    }
}
