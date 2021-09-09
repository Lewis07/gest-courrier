<?php

namespace App\Controller\BackOffice;

use App\Repository\CourrierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/courrier")
 */
class AdminCourrierController extends AbstractController
{
    /**
     * @Route("/", name="admin_courrier_index")
     */
    public function index(CourrierRepository $courrierRepository): Response
    {
        $courriers = $courrierRepository->findAll();
        
        return $this->render('BackOffice/Courrier/index.html.twig', compact('courriers'));
    }
}
