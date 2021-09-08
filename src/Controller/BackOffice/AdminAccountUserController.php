<?php

namespace App\Controller\BackOffice;

use App\Entity\User;
use App\Form\RoleUserType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/compte-d-utilisateur")
 * Class AdminAccountUserController
 * @package App\Controller\BackOffice
 */
class AdminAccountUserController extends AbstractController
{
    private $em;
    private $roleRepository;

    /**
     * AdminAccountUserController constructor.
     * @param EntityManagerInterface $em
     * @param RoleRepository $roleRepository
     */
    public function __construct(EntityManagerInterface $em, RoleRepository $roleRepository)
    {
        $this->em = $em;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Affiche la liste des utilisateurs
     * @Route("/", name="admin_user_index")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('BackOffice/User/index.html.twig', compact('users'));
    }

    /**
     * Modification de l'accès de l'utilisateur
     * @Route("/{id}/edit", name="admin_user_edit")
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request,User $user, UserPasswordEncoderInterface $encoder)
    {
        $userRoles = $user->getRoles();
        $form = $this->createForm(RoleUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $role_id = $form->get("role")->getData()->getId();

            if ($role_id) {
                $role_title = $this->roleRepository->find($role_id)->getTitreRole();
            }

            if (in_array($role_title, $userRoles)) {
                $this->addFlash("danger","This user has already this role");
                return $this->redirectToRoute('admin_user_index');
            }

            array_push($userRoles,$role_title);
            $user->setRoles($userRoles);

//            $role = ucfirst(strtolower(str_replace("ROLE_","", $role_title)));
            $this->em->flush();
            
            $this->addFlash(
                'success',
                "La modification de l’<strong>utilisateur</strong> a été bien modifié avec succès "
            );

            return $this->redirectToRoute('admin_user_index');
        }
        
       return $this->render("BackOffice/User/edit.html.twig", [
           'form' => $form->createView()
       ]);
    }

    /**
     * Suppression de l'utilisateur
     * @Route("/{id}/delete", name = "admin_user_delete")
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(EntityManagerInterface $manager, user $user)
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_user_index');
    }
}
