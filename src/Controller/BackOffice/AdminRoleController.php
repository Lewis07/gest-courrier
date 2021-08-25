<?php

namespace App\Controller\BackOffice;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/role")
 */
class AdminRoleController extends AbstractController
{
    private $em;

    /**
     * AdminRoleController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Affiche la liste des roles
     * @Route("/", name="admin_role_index", methods={"GET"})
     * @param RoleRepository $roleRepository
     * @return Response
     */
    public function index(RoleRepository $roleRepository): Response
    {
        $roles = $roleRepository->findAll();

        return $this->render('BackOffice/Role/index.html.twig', compact('roles'));
    }

    /**
     * Ajouter un role
     * @Route("/ajout", name="admin_role_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($role);
            $this->em->flush();

            return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Role/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification du role
     * @Route("/{id}/edit", name="admin_role_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function edit(Request $request, Role $role): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('BackOffice/Role/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression du role
     * @Route("/{id}/delete", name="admin_role_delete")
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function delete(Request $request, Role $role): Response
    {
        $this->em->remove($role);
        $this->em->flush();

        return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
    }
}
