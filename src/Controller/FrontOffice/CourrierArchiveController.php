<?php

namespace App\Controller\FrontOffice;

use App\Entity\Courrier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourrierArchiveController extends AbstractController
{
    private $em;

    /**
     * CourrierArchiveController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Suppression du courrier archive vers corbeille
     * @Route("/{id}/delete-to-trash-archived", name="courrier_delete_trash_archived")
     * @param Courrier $courrier
     * @param Request $request
     * @param $route_name
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteInTrash(Courrier $courrier, Request $request)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier->setIsInTrashed(true);
        $this->em->persist($courrier);

        $this->em->flush();

        return $this->redirectToRoute('courrier_archived');
    }
}
