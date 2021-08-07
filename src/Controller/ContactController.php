<?php

namespace App\Controller;

use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/{message}', name: 'contact')]
    public function index($message = null): Response
    {
        
        return $this->render('contact/index.html.twig', [
            'message' => $message,
        ]);
    }

   
    #[Route('/contact/msg/submit', name: 'contact_submit')]
    public function submit(Request $request, \Swift_Mailer $mailer): Response
    {

        $email = $request->request->get('email');
        $msg = $request->request->get('message');

        dump($email);

        $message = (new \Swift_Message('Message From your website !'))
        ->setFrom($email)
        ->setTo('hodajatte.smtp@gmail.com')
        ->setBody(
            $this->renderView(
                'emails/contact.html.twig',
                ['message' => $msg]
            ),
            'text/html'
        );

        

        if($mailer->send($message) == 0) {

            return $this->redirectToRoute("contact", ['message' => "Votre message n'est pas Envoyer"]);
        }
        else {
            return $this->redirectToRoute("contact", ['message' => 'Votre message est Envoyer']);
        }
        

    }
}
