<?php

namespace App\Controller;

use App\Controller\Handler\HandlerApiAddUser;
use App\Controller\Handler\LinksForApi;
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
     *         @SWG\Items(ref=@Model(type=User::class))
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The collection page number",
     *     default="1"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function getUsers(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): JsonResponse
    {
        $currentCustom = $this->getUser()->getId();
        $users = $userRepository->findBy(['fk_custom' => $currentCustom]);

        if (!$users) {
            $data = [
                'message' => 'Ressource non trouvé',
                'statut' => 404,
            ];

            return $response = $this->json($data, Response::HTTP_NOT_FOUND, [],
                ['groups' => 'post:read', 'json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }

        $links = new LinksForApi();
        $links->setUsersLinks($users);

        $UsersPagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        $response = $this->json($UsersPagination, Response::HTTP_OK, [],
            ['groups' => 'post:read', 'json_encode_options' => JSON_UNESCAPED_SLASHES]);
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
     *         @SWG\Items(ref=@Model(type=User::class))
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
            $data = [
                'message' => 'Utilisateur ajouté avec succès',
                'statut' => 201,
            ];

            return $response = $this->json($data, Response::HTTP_CREATED,
                [], ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        } else {
            $data = [
                'message' => $requestStatut['errorMessage'],
                'statut' => 412,
            ];

            return $response = $this->json($data, Response::HTTP_PRECONDITION_FAILED,
                [], ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="delete an user in your organisation",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
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

        if (!($user instanceof User)) {
            $data = [
                'message' => 'Utilisateur non trouvé',
                'statut' => 404,
            ];

            return $response = $this->json($data, Response::HTTP_NOT_FOUND, [],
                ['groups' => 'post:read', 'json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }

        $idCustom = $user->getFkCustom()->getId();
        $currentCustom = $this->getUser()->getId();

        if ($idCustom === $currentCustom) {
            $entityManager->remove($user);
            $entityManager->flush();
            $data = [
                'message' => 'Utilisateur supprimé avec succès',
                'statut' => 200,
            ];

            return $response = $this->json($data, Response::HTTP_OK, [],
                ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        } else {
            $data = [
                'message' => 'Vous ne pouvez pas supprimer cet utilisateur',
                'statut' => 404,
            ];

            return $response = $this->json($data,
                Response::HTTP_NOT_FOUND,
                [], ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }
    }

    /**
     * @Route("/users/{id}", name="get_user", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="get an user in your organisation by id",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class))
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
    public function GetOneUser(UserRepository $userRepository, $id, Request $request): JsonResponse
    {
        $users = $userRepository->find($id);

        if (!($users instanceof User)) {
            $data = [
                'message' => 'Utilisateur non trouvé',
                'statut' => 404,
            ];

            return $response = $this->json($data, Response::HTTP_NOT_FOUND, [],
                ['groups' => 'post:read', 'json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }

        $links = new LinksForApi();
        $links->setUsersLinks($users);
        $idCustom = $users->getFkCustom()->getId();
        $currentCustom = $this->getUser()->getId();

        if ($idCustom === $currentCustom) {
            $response = $this->json($users, Response::HTTP_OK, [],
                ['groups' => 'post:read', 'json_encode_options' => JSON_UNESCAPED_SLASHES]);
            $response->setPublic();
            $response->setMaxAge(3600);
            $response->headers->addCacheControlDirective('must-revalidate', true);

            return $response;
        } else {
            $data = [
                'message' => 'Accès aux informations interdit',
                'statut' => 203,
            ];

            return $response = $this->json($data, Response::HTTP_NON_AUTHORITATIVE_INFORMATION,
                [], ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        }
    }
}
