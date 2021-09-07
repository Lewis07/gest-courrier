<?php

namespace App\Controller\FrontOffice;

use App\Entity\Courrier;
use App\Repository\CourrierArchiveRepository;
use App\Repository\CourrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourrierArchiveController extends AbstractController
{
    private $em;
    private $courrierRepository;
    private $courrierArchiveRepository;

    /**
     * CourrierArchiveController constructor.
     * @param EntityManagerInterface $em
     * @param CourrierRepository $courrierRepository
     * @param CourrierArchiveRepository $courrierArchiveRepository
     */
    public function __construct(EntityManagerInterface $em, CourrierRepository $courrierRepository,
                                CourrierArchiveRepository $courrierArchiveRepository)
    {
        $this->em = $em;
        $this->courrierRepository = $courrierRepository;
        $this->courrierArchiveRepository = $courrierArchiveRepository;
    }

    /**
     * Suppression du courrier archive vers corbeille
     * @Route("/{id}/delete-to-trash-archived", name="courrier_delete_trash_archived")
     * @param Courrier $courrier
     * @param Request $request
     * @param $route_name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteInTrash(Courrier $courrier, Request $request, $id)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier_archive = $this->courrierArchiveRepository->find($id);

        $courrier_archive->setIsInTrashed(true);
        $this->em->persist($courrier_archive);

        $this->em->flush();

        return $this->redirectToRoute('courrier_archived');
    }
}
