<?php

namespace App\Controller\BackOffice;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/departement")
 */
class AdminDepartementController extends AbstractController
{
    private $em;

    /**
     * AdminDepartementController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des départements
     * @Route("/", name="admin_departement_index", methods={"GET"})
     * @param DepartementRepository $departementRepository
     * @return Response
     */
    public function index(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAll();

        return $this->render('BackOffice/Departement/index.html.twig', compact('departements'));
    }

    /**
     * Ajouter un département
     * @Route("/ajout", name="admin_departement_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($departement);
            $this->em->flush();

            return $this->redirectToRoute('admin_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Departement/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification du département
     * @Route("/{id}/edit", name="admin_departement_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Departement $departement
     * @return Response
     */
    public function edit(Request $request, Departement $departement): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Departement/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Suppression du département
     * @Route("/{id}/delete", name="admin_departement_delete")
     * @param Request $request
     * @param Departement $departement
     * @return Response
     */
    public function delete(Request $request, Departement $departement): Response
    {
        $this->em->remove($departement);
        $this->em->flush();

        return $this->redirectToRoute('admin_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
