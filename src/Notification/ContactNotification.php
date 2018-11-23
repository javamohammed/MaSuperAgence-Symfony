<?php

namespace App\Notification;

use \App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    private $mailer;
    private $twig;

   public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;


    }
    public function Notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence : '.$contact->getProperty()->getTitle()))
            ->setFrom('noreplyd@agence.com')
            ->setTo('contact@agence.com')
            ->setReplyTo($contact->getEmail())
            ->setBody('koko'
                /*$this->twig->render(
                    'emails/contact.html.twig',
                    [
                        'contact' => $contact
                    ]
                )*/,
                'text/html'
            )
        ;

        $this->mailer->send($message);

    }
}

?>
