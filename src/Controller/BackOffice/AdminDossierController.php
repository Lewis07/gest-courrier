<?php

namespace App\Controller\BackOffice;

use App\Entity\Dossier;
use App\Form\DossierType;
use App\Repository\DossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/dossier")
*/
class AdminDossierController extends AbstractController
{
    /**
     * @Route("/", name="admin_dossier_index")
     */
    public function index(DossierRepository $dossierRepository): Response
    {
        return $this->render('BackOffice/Dossier/index.html.twig', [
            'dossiers' => $dossierRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="dossier_new")
     */
    public function create(Request $request,EntityManagerInterface $manager)
    {
        $dossier = new Dossier();
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($dossier);
            $manager->flush();

            return $this->redirectToRoute('dossier');
        }



       return $this->render('dossier/add.html.twig', [
           'form' => $form->createView()
       ]);
    }


    /**
     * @Route("/{id}/edit", name="dossier_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Dossier $dossier)
    {
        $form = $this->createForm(DossierType::class, $dossier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($dossier);
            $manager->flush();

        return $this->redirectToRoute('dossier');
        }

       return $this->render('dossier/add.html.twig', [
           'form' => $form->createView()
       ]);
    }

    /**
     * @Route("/{id}/delete", name="dossier_delete")
     */
    public function delete(EntityManagerInterface $manager,Dossier $dossier)
    {
        $manager->remove($dossier);
        $manager->flush();
        return $this->redirectToRoute('dossier');
    }
}
