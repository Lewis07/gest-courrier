<?php

namespace App\Controller\BackOffice;

use App\Entity\TypeCourrier;
use App\Entity\TypeDossier;
use App\Form\TypeCourrierType;
use App\Form\TypeDossierType;
use App\Repository\TypeCourrierRepository;
use App\Repository\TypeDossierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type-courrier")
 */
class AdminTypeCourrierController extends AbstractController
{
    private $em;

    /**
     * AdminTypeCourrierController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des types de courriers
     * @Route("/", name="admin_type_courrier_index", methods={"GET"})
     * @param TypeCourrierRepository $typeCourrierRepository
     * @return Response
     */
    public function index(TypeCourrierRepository $typeCourrierRepository): Response
    {
        $type_courriers = $typeCourrierRepository->findAll();

        return $this->render('BackOffice/TypeCourrier/index.html.twig', compact('type_courriers'));
    }

    /**
     * Ajouter un type de courrier
     * @Route("/ajout", name="admin_type_courrier_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $typeCourrier = new TypeCourrier();
        $form = $this->createForm(TypeCourrierType::class, $typeCourrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($typeCourrier);
            $this->em->flush();

            return $this->redirectToRoute('admin_type_courrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/TypeCourrier/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier un type de courrier
     * @Route("/{id}/edit", name="admin_type_courrier_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TypeCourrier $typeCourrier
     * @return Response
     */
    public function edit(Request $request, TypeCourrier $typeCourrier): Response
    {
        $form = $this->createForm(TypeCourrierType::class, $typeCourrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_type_courrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/TypeCourrier/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprimer un type de courrier
     * @Route("/{id}/delete", name="admin_type_courrier_delete")
     * @param TypeCourrier $typeCourrier
     * @return Response
     */
    public function delete(TypeCourrier $typeCourrier): Response
    {
        $this->em->remove($typeCourrier);
        $this->em->flush();

        return $this->redirectToRoute('admin_type_courrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
