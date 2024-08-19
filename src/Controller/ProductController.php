<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderFormType;
use App\Repository\ProductRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private OrderFormType $orderForm) {}

    #[Route('/product/{product}', name: 'app_product')]
    public function index(Product $product): Response
    {
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/shopping', name: 'app_shopping')]
    public function myShopping(Request $request): Response
    {
        // récupérer dans le storage les items qu'ont a ajouté dedans en forme de tableau
        $session = $request->getSession();
        $cards = $session->get('cards');
        // dd($cards);
        $cardsData = [];
        $total = 0;

        if (!empty($cards)) {
            foreach ($cards as $id => $quantity) {
                $cardsData[] = [
                    'product' => $this->productRepository->find($id),
                    'quantity' => $quantity
                ];
            }

            foreach ($cardsData as $item) {
                $totalItem = $item['product']->getPrice() * $item['quantity'];
                $total += $totalItem;
            }

            $order = new Order();
            $order->setDate(new DateTime())
                ->setPrice($totalItem)
                ->setUserId($this->getUser());
            $orderForm = $this->createForm(OrderFormType::class, $order);
        }

        // return $this->render('product/shopping.html.twig', []);
        return $this->render('product/shopping.html.twig', [
            'products' => $cardsData,
            'total' => $total,
            'orderForm' => $orderForm
        ]);
    }

    #[Route('/addTocard/{id}', name: 'app_addToCard')]
    public function addToCard(Request $request, int $id)
    {
        // si c'est le meme id on ajoute quantity + 1
        $session = $request->getSession();
        $cards = $session->get('cards', []);

        if (!empty($cards[$id])) {
            $cards[$id]++;
        } else {
            $cards[$id] = 1;
        }

        $session->set('cards', $cards);

        return $this->redirectToRoute('app_product', ['product' => $id]);
    }

    #[Route('/removeCard', name: 'app_removeCard')]
    public function removeCard(Request $request)
    {
        $session = $request->getSession();
        $session->remove('cards');
        return $this->redirectToRoute('app_shopping');
    }
}
