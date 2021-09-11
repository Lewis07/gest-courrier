<?php

namespace App\Controller\BackOffice;

use App\Entity\Courrier;
use App\Repository\CourrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     *@Route("/{id}/voir", name="show_courriers")
     */
    public function VoirCourrier(Courrier $courrier)
    {
        return $this->render("BackOffice/Courrier/voircourrier.html.twig", compact('courrier'));
    }

    /**
     * @Route("/{id}/delete", name="delete_courrier")
     */
    public function deletecourrier(Courrier $courrier, EntityManagerInterface $manager)
    {
        $manager->remove($courrier);
        $manager->flush();

        return $this->redirectToRoute('admin_courrier_index');
    }
}

