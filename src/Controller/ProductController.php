<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Form\OrderFormType;
use App\Repository\ProductRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use function Symfony\Component\Clock\now;

class ProductController extends AbstractController
{
    public function __construct(private ProductRepository $productRepository, private OrderFormType $orderForm)
    {
    }

    #[Route('/product/{product}', name: 'app_product')]
    public function index(Product $product): Response
    {
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/shopping', name: 'app_shopping')]
    public function myShopping(Request $request): Response
    {
        // récupérer dans le storage les items qu'ont a ajouté dedans en forme de tableau
        $session = $request->getSession();
        $cards = $session->get('cards');
        $total = 0;
        $regroupedCards = [];


        if (!empty($cards)) {
            foreach ($cards as $card) {
                $total += $card->getPrice();
                $productId = $card->getId();
                if (!isset($regroupedCards[$productId])) {
                    $regroupedCards[$productId] = [
                        'product' => $card,
                        'quantity' => 0
                    ];
                }
                $regroupedCards[$productId]['quantity']++;
            }
        }
        return $this->render('product/shopping.html.twig', [
            'products' => $regroupedCards,
            'total' => $total,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/addTocard/{id}', name: 'app_addToCard')]
    public function addToCard(Request $request, int $id)
    {
        $session = $request->getSession();
        $cards = $session->get('cards', []);

        $product = $this->productRepository->find($id);
        array_push($cards, $product);
        $session->set("cards", $cards);

        return $this->redirectToRoute('app_product', ['product' => $id]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/removeCard', name: 'app_removeCard')]
    public function removeCard(Request $request)
    {
        $session = $request->getSession();
        $session->remove('cards');
        return $this->redirectToRoute('app_shopping');
    }

    #[Route('/api/products', name: 'app_api_products', methods: ['GET'])]
    public function apiProducts(): JsonResponse
    {
        /**@var User $user */
        $user = $this->getUser();
        $activeApi = $user->isActiveApi();
        if (!$activeApi) {
            return $this->json([
                'message' => 'Accès API non activé'
            ], Response::HTTP_FORBIDDEN);
        }

        $products = $this->productRepository->findAllDesc();
        return $this->json($products);
    }
}
