<?php

namespace App\Controller\FrontOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil
     * @Route("/accueil",name="home")
     * @return Response
     */
    public function home(): Response{
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        return $this->render('FrontOffice/Home/index.html.twig');
    }
}
