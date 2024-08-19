<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order/{product}', name: 'app_order', methods: 'POST')]
    public function index(Request $request)
    {

        dd($request);

        return $this->redirectToRoute('app_profile');
    }
}
