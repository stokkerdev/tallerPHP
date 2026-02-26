<?php

namespace App\Service;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class generarEmail
{
    private MailerInterface $mailer;

    public function __construct()
    {
        $transport = Transport::fromDsn('smtp://stokkercorreos@gmail.com:prht%20wvhf%20fcej%20rvuc@smtp.gmail.com:587');
        $this->mailer = new Mailer($transport);
    }

    public function sendReport(string $to, string $subject, string $htmlContent): void
    {
        $email = (new Email())
            ->from('noreply@tallerphp.local')
            ->to($to)
            ->subject($subject)
            ->html($htmlContent);

        $this->mailer->send($email);
    }
}