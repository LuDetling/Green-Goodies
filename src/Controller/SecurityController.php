<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException($this->redirectToRoute("app_home"));
    }

    #[Route(path: '/api/login', name: 'app_api_login', methods: ['POST'])]
    public function apiLogin(#[CurrentUser] ?User $user, Request $request, AuthenticationUtils $authenticationUtils): Response
    {

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->request->get("token");

        return $this->json([
            'message' => "Welcome to your new controller!",
            'path' => 'src/controller/ApiLoginController.php',
            'user' => $user->getUserIdentifier(),
            'token' => $token
        ]);
    }
}
