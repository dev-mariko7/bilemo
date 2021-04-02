<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Knp\Component\Pager\PaginatorInterface;
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

        return $response = $this->json($ProductsPagination, Response::HTTP_OK, [], ['groups' => 'post:read']);
    }

    /**
     * @Route("/products/{id}", name="get_one_product", methods={"GET"})
     */
    public function getOneProduct(ProductsRepository $productsRepository, $id, Request $request,
                                PaginatorInterface $paginator): JsonResponse
    {
        $product = $productsRepository->find($id);

        if (!$product) {
            return $response = $this->json('', Response::HTTP_NO_CONTENT, [], ['groups' => 'post:read']);
        }

        return $response = $this->json($product, Response::HTTP_OK, [], ['groups' => 'post:read']);
    }
}
