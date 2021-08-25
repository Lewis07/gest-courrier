<?php

namespace App\Controller\BackOffice;

use App\Entity\TypeDossier;
use App\Form\TypeDossierType;
use App\Repository\TypeDossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type-dossier")
 */
class AdminTypeDossierController extends AbstractController
{
    private $em;

    /**
     * AdminTypeDossierController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des types de dossiers
     * @Route("/", name="admin_type_dossier_index", methods={"GET"})
     * @param TypeDossierRepository $typeDossierRepository
     * @return Response
     */
    public function index(TypeDossierRepository $typeDossierRepository): Response
    {
        $type_dossiers = $typeDossierRepository->findAll();

        return $this->render('BackOffice/TypeDossier/index.html.twig', compact('type_dossiers'));
    }

    /**
     * Ajouter un type de dossier
     * @Route("/ajout", name="admin_type_dossier_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $typeDossier = new TypeDossier();
        $form = $this->createForm(TypeDossierType::class, $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($typeDossier);
            $this->em->flush();

            return $this->redirectToRoute('admin_type_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/TypeDossier/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier un type de dossier
     * @Route("/{id}/edit", name="admin_type_dossier_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeDossier $typeDossier
     * @return Response
     */
    public function edit(Request $request, TypeDossier $typeDossier): Response
    {
        $form = $this->createForm(TypeDossierType::class, $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_type_dossier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/TypeDossier/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer un type de dossier
     * @Route("/{id}/delete", name="admin_type_dossier_delete")
     * @param Request $request
     * @param TypeDossier $typeDossier
     * @return Response
     */
    public function delete(TypeDossier $typeDossier): Response
    {
        $this->em->remove($typeDossier);
        $this->em->flush();

        return $this->redirectToRoute('admin_type_dossier_index', [], Response::HTTP_SEE_OTHER);
    }
}
