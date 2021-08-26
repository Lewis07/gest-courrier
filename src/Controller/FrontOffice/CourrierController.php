<?php

namespace App\Controller\FrontOffice;

use App\Entity\Courrier;
use App\Form\CourrierType;
use App\Form\ValidationCourrierType;
use App\Repository\CourrierRepository;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CourrierController
 * @package App\Controller
 * @Route("/courrier")
 */
class CourrierController extends AbstractController
{
    private $em;
    private $courrierRepository;
    private $sendEmail;

    /**
     * CourrierController constructor.
     * @param EntityManagerInterface $em
     * @param CourrierRepository $courrierRepository
     * @param SendEmailService $sendEmail
     */
    public function __construct(EntityManagerInterface $em, CourrierRepository $courrierRepository,
                                SendEmailService $sendEmail)
    {
        $this->em = $em;
        $this->courrierRepository = $courrierRepository;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Nouveau courrier
     * @Route("/nouveau", name="courrier_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier = new Courrier();
        $form = $this->createForm(CourrierType::class, $courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $courrier->setSender($this->getUser());

            $this->em->persist($courrier);
            $this->em->flush();

            $this->addFlash("success", "message envoyé avec succès");

            return $this->redirectToRoute("courrier_sent");
        }

        return $this->render('FrontOffice/Courrier/add.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     * Boite de reception
     * @Route("/boite-de-reception", name="courrier_received")
     * @return Response
     */
    public function received(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $received_courriers = $this->courrierRepository->findBy(['recipient' => $user_id, 'isInTrashed' => 0, 'isArchived' => 0]);
            $count_received_courrier_read = count($this->courrierRepository->findBy(['isRead' => 0]));
        }

        return $this->render('FrontOffice/Courrier/Recu/received.html.twig',
            compact('received_courriers','count_received_courrier_read')
        );
    }

    /**
     * Voir la boite de reception
     * @Route("/boite-de-reception/voir", name="courrier_received_show")
     * @return Response
     */
    public function showReceived(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $received_courrier = $this->courrierRepository->findOneBy(['recipient' => $user_id]);
        }

        $received_courrier->setIsRead(true);
        $this->em->persist($received_courrier);
        $this->em->flush();

        return $this->render('FrontOffice/Courrier/Recu/show_received.html.twig',
                                compact('received_courrier')
        );
    }

    /**
     * Courrier envoyé
     * @Route("/courrier-envoye", name="courrier_sent")
     * @return Response
     */
    public function sent(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $sent_courriers = $this->courrierRepository->findBy(['sender' => $user_id]);
        }

        return $this->render('FrontOffice/Courrier/Envoyé/sent.html.twig', compact('sent_courriers'));
    }

    /**
     * Voir la courrier envoyé
     * @Route("/courrier-envoye/voir", name="courrier_sent_show")
     * @return Response
     */
    public function showSent(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $sent_courrier = $this->courrierRepository->findOneBy(['sender' => $user_id]);
        }

        $sent_courrier->setIsRead(true);
        $this->em->persist($sent_courrier);
        $this->em->flush();

        return $this->render('FrontOffice/Courrier/Envoyé/show_sent.html.twig', compact('sent_courrier'));
    }

    /**
     * Affiche la page de validation de courrier
     * @Route("/validation", name="courrier_validation")
     * @return Response
     */
    public function validation(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $validation_courriers = $this->courrierRepository->findBy(['sender' => $user_id, 'isInTrashed' => 0]);
        }

        return $this->render('FrontOffice/Courrier/Validation/validation_courrier.html.twig',
            compact('validation_courriers')
        );
    }

    /**
     * Demander une validation
     * @Route("/demande-validation", name="mail_validation_request")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function mailValidationRequest(Request $request)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier = new Courrier();
        $form = $this->createForm(ValidationCourrierType::class, $courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $courrier->setSender($this->getUser());
            $courrier->setObjetCourrier("Demande de validation de courrier");

            $this->em->persist($courrier);
            $this->em->flush();

            $this->addFlash("success", "message envoyé avec succès");

            return $this->redirectToRoute("courrier_sent");
        }

        return $this->render('FrontOffice/Courrier/add.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     *  Valide le courrier
     * @Route("/{id}/valide-courrier", name="valide_request")
     * @param Courrier $courrier
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateRequest(Courrier $courrier)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $emailFrom = "a@gmail.com";
        $emailTo = "rabarilewis@gmail.com";
        $subject = "Courrier";
        $message = "Message";
        $templale = "template";

        $context = [
            'emailFrom' => $emailFrom,
            'emailTo' => $emailTo,
            'subject' => $subject,
            'message' => $message,
        ];

        $this->sendEmail->send($emailFrom, $emailTo, $subject, $templale, $context);

//        dd($context);

        $courrier->setIsValid(1);
        $this->em->flush();

        return $this->redirectToRoute("courrier_received");
    }

    /**
     * Voir le courrier à valider
     * @Route("/courrier-valide/voir", name="courrier_request_show")
     * @return Response
     */
    public function showMailRequest(): Response
    {
        if ($this->getUser()){
            $user_id = $this->getUser()->getId();
        }

        if (!empty($user_id)){
            $request_courrier = $this->courrierRepository->findOneBy(['recipient' => $user_id]);
        }

        return $this->render('FrontOffice/Courrier/Validation/show_request_validate.html.twig', compact('request_courrier'));
    }

    /**
     * Affiche le courrier archivé
     * @Route("/archive", name="courrier_archived")
     * @return Response
     */
    public function archived(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $archived_courriers = $this->courrierRepository->findBy(['recipient' => $user_id, 'isArchived' => 1, 'isInTrashed' => 0]);
        }

        return $this->render('FrontOffice/Courrier/Archive/archived.html.twig',
            compact('archived_courriers')
        );
    }

    /**
     * Corbeille
     * @Route("/corbeille", name="courrier_trash")
     * @return Response
     */
    public function trash(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $trashes = $this->courrierRepository->findBy(['isInTrashed' => 1]);

        return $this->render('FrontOffice/Courrier/Corbeille/trash.html.twig', compact('trashes'));
    }

    /**
     * Archivé
     * @Route("/{id}/achive-le-courrier", name="archived")
     * @return Response
     */
    public function archivedCourrier(Courrier $courrier): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier->setIsArchived(true);
        $this->em->persist($courrier);
        $this->em->flush();

        $user_id = $this->getUser()->getId();

        if (!empty($user_id)){
            $received_courriers = $this->courrierRepository->findBy(['recipient' => $user_id, 'isInTrashed' => 0]);
            $count_received_courrier_read = count($this->courrierRepository->findBy(['isRead' => 0]));
        }

        return $this->render('FrontOffice/Courrier/Recu/received.html.twig',
            compact('received_courriers','count_received_courrier_read')
        );
    }

    /**
     * @Route("/Courrier/{id}/edit", name="courrier_edit")
     */
    public function edit(Request $request,EntityManagerInterface $manager,Courrier $courrier)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(CourrierType::class, $courrier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $manager->persist($courrier);
            $manager->flush();

            return $this->redirectToRoute("courrier");
        }

        return $this->render('Courrier/add.html.twig', [
            'form' => $form->CreateView()
        ]);
    }

    /**
     * Suppression du courrier vers corbeille
     * @Route("/{id}/delete-to-trash", name="courrier_delete_trash")
     * @param Courrier $courrier
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteInTrash(Courrier $courrier)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $courrier->setIsInTrashed(true);
        $this->em->persist($courrier);
        $this->em->flush();

        return $this->redirectToRoute('courrier_received');
    }

    /**
     * Suppression du courrier
     * @Route("/{id}/delete", name="courrier_delete")
     * @param Courrier $courrier
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Courrier $courrier)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $this->em->remove($courrier);
        $this->em->flush();

        return $this->redirectToRoute('courrier_trash');
    }
}

