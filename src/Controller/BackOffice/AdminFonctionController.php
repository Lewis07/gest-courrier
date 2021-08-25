<?php

namespace App\Controller\BackOffice;

use App\Entity\Fonction;
use App\Form\FonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/fonction")
 */
class AdminFonctionController extends AbstractController
{
    private $em;

    /**
     * AdminFonctionController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des fonctions
     * @Route("/", name="admin_fonction_index", methods={"GET"})
     * @param FonctionRepository $fonctionRepository
     * @return Response
     */
    public function index(FonctionRepository $fonctionRepository): Response
    {
        $fonctions = $fonctionRepository->findAll();

        return $this->render('BackOffice/Fonction/index.html.twig', compact('fonctions'));
    }

    /**
     * Ajouter un fonction
     * @Route("/ajout", name="admin_fonction_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $fonction = new Fonction();
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($fonction);
            $this->em->flush();

            return $this->redirectToRoute('admin_fonction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Fonction/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification du fonction
     * @Route("/{id}/edit", name="admin_fonction_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Fonction $fonction
     * @return Response
     */
    public function edit(Request $request, Fonction $fonction): Response
    {
        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_fonction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Fonction/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Suppression du fonction
     * @Route("/{id}/delete", name="admin_fonction_delete")
     * @param Request $request
     * @param Fonction $fonction
     * @return Response
     */
    public function delete(Request $request, Fonction $fonction): Response
    {
        $this->em->remove($fonction);
        $this->em->flush();

        return $this->redirectToRoute('admin_fonction_index', [], Response::HTTP_SEE_OTHER);
    }
}
