<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swift_Mailer;

/**
 * @Route("/")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/index", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message = (new \Swift_Message('Bienvenue chez WikiCampers'))
                ->setFrom('mercibien8@gmail.com')
                ->setTo('mercibien8@gmail.com')
                ->setBody(
                    $this->renderView(
                        'email/contactemail.html.twig'

                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('contact_index');
            }

            return $this->render('contact/new.html.twig', [
                'contact' => $contact,
                'form' => $form->createView(),
            ]);

        }
}