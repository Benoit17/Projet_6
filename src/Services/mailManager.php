<?php

namespace App\Services;

use Twig\Environment;

class MailManager
{
    private $mailer;
    private $env;

    /**
     * ContactManager constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $env
     */
    public function __construct(\Swift_Mailer $mailer, Environment $env) {
        $this->mailer = $mailer;
        $this->env = $env;
    }

    public function sendMail($data) {
        $message = (new \Swift_Message('Contact'))
            ->setFrom($data['email'])
            ->setTo('dumaschaumette@gmail.com')
            ->setBody($this->env->render('default/mail.html.twig', array(
                'data' => $data
            )), 'text/html');

        // Envoi de l'email
        $this->mailer->send($message);

    }
}