<?php

namespace App\Controller\FrontOffice;

use App\Entity\Dossier;
use App\Form\CourrierClasserType;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/courrier-classer")
*/
class CourrierClasserController extends AbstractController
{
    private $em;

    /**
     * CourrierClasserController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="courrier_classer")
     */
    public function index(DossierRepository $dossierRepository): Response
    {
        $courrier_classers = $dossierRepository->findAll();
        return $this->render('FrontOffice/courrier_classer/index.html.twig', compact('courrier_classers'));
    }

    /**
     * @Route("/ajout", name="courrier_classer_new")
     */
    public function create(Request $request)
    {
        $courrier_classer = new Dossier();
        $form = $this->createForm(CourrierClasserType::class, $courrier_classer);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($courrier_classer);
            $this->em->flush();

            return $this->redirectToRoute('courrier_classer');
        }

       return $this->render('FrontOffice/courrier_classer/add.html.twig', [
           'form' => $form->createView()
       ]);
    }

    /**
     * Route("/{id}/delete", name"classer_delete")
     */
    public function delete(EntityManagerInterface $manager,Dossier $dossier)
    {
        $manager->remove($dossier);
        $manager->flush();
        return $this->redirectToRoute('courrier_classer');
    }
}
