<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDossierController extends AbstractController
{
    /**
     * @Route("/admin/dossier", name="admin_dossier_index")
     */
    public function index(): Response
    {
        return $this->render('BackOffice/Dossier/index.html.twig', [
            'controller_name' => 'AdminDossierController',
        ]);
    }
}
