<?php

namespace App\Controller\FrontOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourrierRepository;

class HomeController extends AbstractController
{
    private $courrierRepository;

    public function __construct(CourrierRepository $courrierRepository){
        $this->courrierRepository = $courrierRepository;
    }

    /**
     * Affiche la page d'accueil
     * @Route("/accueil",name="home")
     * @return Response
     */
    public function home(): Response{
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $courriers_arrive = $this->courrierRepository->findBy(['recipient' => $user_id, 'isInTrashed' => 0]);
            $count_courrier_arrive = count($courriers_arrive);

            $courriers_depart = $this->courrierRepository->findBy(['sender' => $user_id, 'isInTrashed' => 0, 'isArchived' => 0]);
            $count_courrier_depart = count($courriers_depart);

            $courriers_archive = $this->courrierRepository->findBy(['sender' => $user_id, 'isArchived' => 1, 'isInTrashed' => 0]);
            $count_courrier_archive = count($courriers_archive);
        }

        return $this->render('FrontOffice/Home/index.html.twig',
                            compact('count_courrier_arrive','count_courrier_depart','count_courrier_archive')
        );
    }
}
