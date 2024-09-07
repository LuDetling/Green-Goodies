<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order', methods: 'POST')]
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $total = $request->request->get('total');

        $order = new Order();
        $order->setDate(new DateTime())
            ->setPrice($total)
            ->setUser($this->getUser());
        $entityManager->persist($order);
        $entityManager->flush();
        $session = $request->getSession();
        $session->remove('cards');
        return $this->redirectToRoute('app_profile');
    }
}
