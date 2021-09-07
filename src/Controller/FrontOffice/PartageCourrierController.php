<?php

namespace App\Controller\FrontOffice;

use App\Entity\Courrier;
use App\Entity\PartageCourrier;
use App\Form\PartageCourrierType;
use App\Repository\CourrierRepository;
use App\Repository\PartageCourrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/courrier/partage")
 */
class PartageCourrierController extends AbstractController
{
    private $em;
    private $partageCourrierRepository;
    private $courrierRepository;

    /**
     * PartageCourrierController constructor.
     * @param EntityManagerInterface $em
     * @param PartageCourrierRepository $partageCourrierRepository
     * @param CourrierRepository $courrierRepository
     */
    public function __construct(EntityManagerInterface $em, PartageCourrierRepository $partageCourrierRepository,
                                CourrierRepository $courrierRepository)
    {
        $this->em = $em;
        $this->partageCourrierRepository = $partageCourrierRepository;
        $this->courrierRepository = $courrierRepository;
    }
    /**
     * @Route("/", name="partage_courrier_index")
     */
    public function index(): Response
    {
        /*if ($this->getUser()){
            $partage_courriers = $this->partageCourrierRepository->partageCourrierUtilisateur($this->getUser()->getId());
        }*/

        $partageurs = $this->partageCourrierRepository->findBy(['sender' => $this->getUser()]);
        $partage_courriers = [];

        foreach ($partageurs as $partageur){
            $sender_id = $partageur->getSender()->getId();
            $partage_courriers = $this->courrierRepository->findBy(['sender' => $sender_id,'isInTrashed' => 0,'isShared' => 1]);
        }

        return $this->render('FrontOffice/Courrier/Partage/partage.html.twig', compact('partage_courriers'));
    }

    /**
     * Partager un courrier
     * @Route("/{courrier_id}/utilisateur", name="courrier_share_user")
     * @param Request $request
     * @param $courrier_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function courrierShareUser(Request $request, $courrier_id)
    {
        $partage_courrier = new PartageCourrier();

        $form = $this->createForm(PartageCourrierType::class, $partage_courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $_recipients = $form->get("recepteur_courrier_partage")->getData();
            $partage_courrier->setSender($this->getUser());

            foreach ($_recipients as $shared){
                $partage_courrier->addSharer($shared);
            }

            $courrier = $this->courrierRepository->find($courrier_id);
            $courrier->setIsShared(true);

            $this->em->persist($partage_courrier);
            $this->em->persist($courrier);
            $this->em->flush();

            $this->addFlash("success", "message envoyé avec succès");

            return $this->redirectToRoute("courrier_sent");
        }

        return $this->render('FrontOffice/Partage/partage.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     * Suppression du courrier vers corbeille
     * @Route("/{id}/delete-to-trash-partage", name="courrier_delete_trash_share")
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

        return $this->redirectToRoute('partage_courrier_index');
    }

}
