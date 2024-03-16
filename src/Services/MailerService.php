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
        $this->mailer = $mailer;
        $this->twig = $twig;    
    }

    public function sendEmail(string $subject, string $from, string $to, string $template, array $data ): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($this->twig->render($template, $data ), charset: 'text/html');

        $this->mailer->send($email);
    }
}
