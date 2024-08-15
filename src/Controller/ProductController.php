<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{product}', name: 'app_product')]
    public function index(Product $product): Response
    {
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/shopping', name: 'app_shopping')]
    public function myShopping (): Response
    {
        // récupérer dans le storage les items qu'ont a ajouté dedans en forme de tableau
        return $this->render('product/shopping.html.twig');
    }
}
