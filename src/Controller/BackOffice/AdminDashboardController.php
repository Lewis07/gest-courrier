<?php

namespace App\Controller\BackOffice;

use App\Repository\CourrierRepository;
use App\Repository\DepartementRepository;
use App\Repository\DirectionRepository;
use App\Repository\DossierRepository;
use App\Repository\FonctionRepository;
use App\Repository\RoleRepository;
use App\Repository\TypeDossierRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * Affiche le tableau de bord
     * @Route("/admin/tableau-de-bord", name="admin_dashboard")
     * @param CourrierRepository $courrierRepository
     * @param DirectionRepository $directionRepository
     * @param DossierRepository $dossierRepository
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param DepartementRepository $departementRepository
     * @param FonctionRepository $fonctionRepository
     * @param TypeDossierRepository $typeDossierRepository
     * @return Response
     */
    public function index(CourrierRepository $courrierRepository,
                          DirectionRepository $directionRepository,
                          DossierRepository $dossierRepository,
                          UserRepository $userRepository,
                          RoleRepository $roleRepository,
                          DepartementRepository $departementRepository,
                          FonctionRepository $fonctionRepository,
                          TypeDossierRepository $typeDossierRepository): Response
    {
//        if(!$this->getUser()){
//            return $this->redirectToRoute('app_login');
//        }

        $users = count($userRepository->findAll());
        $types_dossiers = count($typeDossierRepository->findAll());
        $courriers = count($courrierRepository->findAll());
        $directions = count($directionRepository->findAll());
        $dossiers = count($dossierRepository->findAll());
        $roles = count($roleRepository->findAll());
        $departements = count($departementRepository->findAll());
        $fonctions = count($fonctionRepository->findAll());

        return $this->render('BackOffice/Dashboard/index.html.twig',
                            compact('users','courriers','directions',
                                    'directions','dossiers','roles','departements',
                                    'fonctions','types_dossiers')
        );
    }
}
