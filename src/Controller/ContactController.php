<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response {
        
        $contact = new Contact();
        
        if ($this->getUser()) {
            $contact->setNom($this->getUser()->getNom())
                ->setEmail($this->getUser()->getEmail());
            
        }     
        

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            $contact = $form->getData();
           

            $manager->persist($contact);
            $manager->flush();

            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('contact@bestbrico.com')
            ->subject($contact->getSujet())
            ->htmlTemplate('contact/contact.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'contact' => $contact,
            ]);

        $mailer->send($email);
                        
            $this->addFlash(    // Nécessite un block "for message" dans contactIndex.html.twig pour fonctionner
                'success',       
                'Votre message a été envoyé avec succès !'
            );

            return $this->redirectToRoute('app_contact');
        }
        
        return $this->render('contact/contactIndex.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
