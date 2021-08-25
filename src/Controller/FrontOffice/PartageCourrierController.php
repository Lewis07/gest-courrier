<?php

namespace App\Controller\FrontOffice;

use App\Entity\PartageCourrier;
use App\Form\PartageCourrierType;
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

    /**
     * PartageCourrierController constructor.
     * @param EntityManagerInterface $em
     * @param PartageCourrierRepository $partageCourrierRepository
     */
    public function __construct(EntityManagerInterface $em, PartageCourrierRepository $partageCourrierRepository)
    {
        $this->em = $em;
        $this->partageCourrierRepository = $partageCourrierRepository;
    }
    /**
     * @Route("/", name="partage_courrier_index")
     */
    public function index(): Response
    {
//        $partage_courriers = $this->partageCourrierRepository->findAll();

        if ($this->getUser()){
            $partage_courriers = $this->partageCourrierRepository->partageCourrierUtilisateur($this->getUser()->getId());
        }
//
//        dd($partage_courriers);

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
            // dd($this->getUser());
            $_recipients = $form->get("recepteur_courrier_partage")->getData();
            $partage_courrier->setSender($this->getUser());

            foreach ($_recipients as $shared){
                $partage_courrier->addSharer($shared);
            }

            $this->em->persist($partage_courrier);
            $this->em->flush();

            $this->addFlash("success", "message envoyé avec succès");

            return $this->redirectToRoute("courrier_sent");
        }

        return $this->render('FrontOffice/Partage/partage.html.twig', [
            'form' => $form->CreateView()
        ]);
    }
}
