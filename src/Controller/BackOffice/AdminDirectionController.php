<?php

namespace App\Controller\BackOffice;

use App\Entity\Direction;
use App\Form\DirectionType;
use App\Repository\DirectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/direction")
 */
class AdminDirectionController extends AbstractController
{
    private $em;

    /**
     * AdminDirectionController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des directions
     * @Route("/", name="direction_index")
     * @param DirectionRepository $directionRepository
     * @return Response
     */
    public function index(DirectionRepository $directionRepository): Response
    {
        $directions = $directionRepository->findAll();

        return $this->render('BackOffice/Direction/index.html.twig', compact('directions'));
    }

    /**
     * Ajouter une direction
     * @Route("/ajout", name="direction_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $direction = new Direction();
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $this->em->persist($direction);
            $this->em->flush();

            return $this->redirectToRoute("direction_index");
        }

        return $this->render('BackOffice/Direction/add.html.twig', [
            'form'=> $form->CreateView()
        ]);
    }

    /**
     * Modification de la direction
     * @Route("/{id}/edit", name="direction_edit")
     * @param Request $request
     * @param Direction $direction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request,Direction $direction)
    {
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $this->em->flush();

            return $this->redirectToRoute("direction_index");
        }

      return $this->render('BackOffice/Direction/edit.html.twig', [
          'form'=> $form->CreateView()
      ]);
    }

    /**
     * Suppression de la direction
     * @Route("/{id}/delete", name="direction_delete")
     * @param Direction $direction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Direction $direction)
    {
        $this->em->remove($direction);
        $this->em->flush();

        return $this->redirectToRoute('direction_index');
    }
}
