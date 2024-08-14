<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository) {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $products = $this->productRepository->findAllDesc();

        return $this->render('home/index.html.twig', [
            'products' => $products
        ]);
    }
}
