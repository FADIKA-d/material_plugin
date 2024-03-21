<?php
namespace App\Services; 

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService
{
    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {

        // Initialisation des propriétés mailer et twig de l'objet
        $this->mailer = $mailer;
        $this->twig = $twig;    
    }

    /**
 * Fonction pour envoyer un email
 * 
 * @param string $subject Sujet de l'email
 * @param string $from Adresse email de l'expéditeur
 * @param string $to Adresse email du destinataire
 * @param string $template Template Twig à utiliser pour le contenu de l'email
 * @param array $data Données à passer au template pour le rendu
 */
    public function sendEmail(string $subject, string $from, string $to, string $template, array $data ): void
    {
        // Création de l'objet Email avec les informations fournies
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($this->twig->render($template, $data ), charset: 'text/html');
// Envoi de l'email via le service mailer configuré
        $this->mailer->send($email);
    }
}
