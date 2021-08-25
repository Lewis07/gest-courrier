<?php

namespace App\Controller\MemberArea;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//         if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
//             return $this->redirectToRoute('admin_dashboard');
//         } elseif ($this->getUser()) {
//             return $this->redirectToRoute('home');
//         }

        // Obtient l'erreur
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur
        $last_username = $authenticationUtils->getLastUsername();

        // Message d'erreur
        $error_message = "Votre email ou votre mot de passe est incorrecte";

        return $this->render('security/login.html.twig',
                                    compact('last_username','error','error_message')
                            );
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
