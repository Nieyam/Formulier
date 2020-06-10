<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $contactFormData = $form->getData();

            $message = (new \Swift_Message($contactFormData['onderwerp']))
                ->setFrom('nadia782022@gmail.com')
                ->setTo($contactFormData['email'])
                ->setBody(
                    $contactFormData['bericht'],
                    'text/plain'
                );
            $mailer->send($message);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
