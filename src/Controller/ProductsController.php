<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductsController.
 *
 * @Route("/api")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="get_products", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns the products",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Products::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="The collection page number",
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     */
    public function getProducts(ProductsRepository $productsRepository, Request $request,
                                PaginatorInterface $paginator): JsonResponse
    {
        $products = $productsRepository->findAll();

        $ProductsPagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            10
        );

        if (!$products) {
            return $response = $this->json('', Response::HTTP_NO_CONTENT, [], ['groups' => 'post:read']);
        }

        $response = $this->json($ProductsPagination, Response::HTTP_OK, [], ['groups' => 'post:read']);
        $response->setPublic();
        $response->setMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @Route("/products/{id}", name="get_one_product", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns an product by id",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Products::class, groups={"post:read"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="the id of product"
     * )
     * @SWG\Tag(name="Products")
     * @Security(name="Bearer")
     *
     * @param $id
     */
    public function getOneProduct(ProductsRepository $productsRepository, $id, Request $request,
                                PaginatorInterface $paginator): JsonResponse
    {
        $product = $productsRepository->find($id);

        if (!$product) {
            return $response = $this->json('', Response::HTTP_NO_CONTENT, [], ['groups' => 'post:read']);
        }

        $response = $this->json($product, Response::HTTP_OK, [], ['groups' => 'post:read']);
        $response->setPublic();
        $response->setMaxAge(3600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}
