<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
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
        $session = $request->getSession();
        $cards = $session->get('cards');
        $order = new Order();
        $order->setDate(new DateTime())
            ->setPrice($total)
            ->setUser($this->getUser());
        foreach ($cards as $productId) {
            $product = $entityManager->getRepository(Product::class)->find($productId);
            if ($product) {
                // vérifier les doublons  
                $existingOrderProduct = null;
                foreach ($order->getOrderProducts() as $orderProduct) {
                    if ($orderProduct->getProductId() === $product) {
                        $existingOrderProduct = $orderProduct;
                        break;
                    }
                }
                if ($existingOrderProduct) {
                    // Si le produit existe déjà, on augmente la quantité
                    $existingOrderProduct->setQuantity($existingOrderProduct->getQuantity() + 1);
                } else {
                    $orderProduct = (new OrderProduct)
                        ->setOrderId($order)
                        ->setProductId($product)
                        ->setQuantity(1);
                    $order->addOrderProduct($orderProduct);
                }
            }
        }
        
        $entityManager->persist($order);
        $entityManager->flush();
        $session->remove('cards');
        return $this->redirectToRoute('app_profile');
    }
}
