<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('notice','Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');

            $contact = $form->getData();
            $content = "Bonjour Administrateur,<br>L'utilisateur ".$contact['prenom']." ".$contact['nom']." (".$contact['email'].") vous transmet ce message :<br>".$contact['content'];
            $mail = new Mail();
            $mail->send('minicrunch25@gmail.com', 'Administrateur', 'Demande de contact',$content);
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
