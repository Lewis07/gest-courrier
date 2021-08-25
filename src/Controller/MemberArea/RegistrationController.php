<?php

namespace App\Controller\MemberArea;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UploadFileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller\MemberArea
 */
class RegistrationController extends AbstractController
{
    private $em;
    private $uploadFileService;

    /**
     * RegistrationController constructor.
     * @param EntityManagerInterface $em
     * @param UploadFileService $uploadFileService
     */
    public function __construct(EntityManagerInterface $em, UploadFileService $uploadFileService)
    {
        $this->em = $em;
        $this->uploadFileService = $uploadFileService;
    }

    /**
     * Inscription de l'utilisateur
     * @Route("/inscription", name="app_register")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->uploadFileService->uploadFile($form, $user, "picture", "upload_images_users_directory");
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash(
                'success',
                "L’<strong>utilisateur</strong> a été bien inscrit"
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render("security/register.html.twig", [
            'form' => $form->createView()
        ]);
    }
}