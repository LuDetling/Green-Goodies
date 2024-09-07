<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/profile', name: 'app_profile')]
    public function index(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['user' => $user], ['id' => 'DESC']);
        return $this->render('user/profile.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/activeApi', name: 'app_active_api', methods: ['POST'])]
    public function activeApi(EntityManagerInterface $entityManager)
    {
        /**@var User $user */
        $user = $this->getUser();
        $user->setActiveApi(!$user->isActiveApi());
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_profile');
    }

    #[Route('/deleteAccount', name: 'app_delete_account', methods: ['GET'])]
    public function deleteAccount(EntityManagerInterface $em)
    {
        $user = $this->getUser();

        if ($user) {
            $em->remove($user);
            $em->flush();

            $this->container->get('security.token_storage')->setToken(null);
            $this->container->get('session')->invalidate();

            return $this->redirectToRoute('app_home');
        }

        return $this->redirectToRoute('app_home');
    }
}
