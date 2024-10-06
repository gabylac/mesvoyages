<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

/**
 * Description of ContactController
 *
 * @author Moi
 */
class ContactController extends AbstractController{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer) : Response {
        $contact= new Contact();
        $formContact= $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted() && $formContact->isValid()){
            $this->sendMail($mailer, $contact);
            $this->addFlash('succes', 'message envoyée');
            return $this->redirectToRoute('contact');
        }
        return $this->render("pages/contact.html.twig", ['contact'=>$contact, 'formcontact'=>$formContact->createView()]);
    }
    
    public function sendMail(MailerInterface $mailer, Contact $contact){
        $email = (new Email())
            ->from($contact->getEmail())
            ->to('contact@mesvoyages.com')
            ->subject('message du site de voyages')
            ->html($this->renderView('pages/_email.html.twig', ['contact'=>$contact]), 'uft-8');

        $mailer->send($email);
    }
}
