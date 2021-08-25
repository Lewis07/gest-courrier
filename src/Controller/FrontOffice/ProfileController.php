<?php

namespace App\Controller\FrontOffice;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/profile", name="Profile")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success',"Votre compte est modifié avec succès");

            return $this->redirectToRoute('home');
        }

        return $this->render('FrontOffice/Profile/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
