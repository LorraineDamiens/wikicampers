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

            $name = $form['name']->getData();
            $firstname = $form['firstname']->getData();
            $email = $form['email']->getData();
            $description = $form['description']->getData();



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $message = (new \Swift_Message('Bienvenue chez WikiCampers'))
                ->setFrom('job@wikicampers.fr')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'email/contactemail.html.twig',array('firstname' => $firstname)
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $message2 = (new \Swift_Message('Formulaire de contact'))
                ->setFrom('job@wikicampers.fr')
                ->setTo('job@wikicampers.fr')
                ->setBody($this->renderView('email/wcemail.html.twig',array('name' => $name, 'firstname' => $firstname, 'email' => $email, 'description' => $description)),'text/plain');

            $mailer->send($message2);


                return $this->redirectToRoute('success');
            }

            return $this->render('contact/new.html.twig', [
                'contact' => $contact,
                'form' => $form->createView(),
            ]);

        }

        /**
         * @Route("/success", name="success")
         */
        public function success()
        {
            return $this->render('contact/redirection.html.twig');
        }
}