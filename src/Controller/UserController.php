<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

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
    #[IsGranted('ROLE_USER')]
    #[Route('/deleteAccount/{id}', name: 'app_delete_account')]
    public function deleteAccount(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $user = $this->userRepository->find($id);
        $userId = $user->getId();

        if ($userId === $id) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('app_home');
    }
}
