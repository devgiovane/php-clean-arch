<?php


declare(strict_types=1);


namespace App\Infra\Adapters;


use PHPMailer\PHPMailer\PHPMailer;
use App\Domain\Entities\Registration;
use App\Application\Contracts\RegistrationMailer;


final class PhpMailerAdapter implements RegistrationMailer
{
    private function configure(&$mailer): void
    {
        $mailer->isSMTP();
        $mailer->SMTPAuth = true;
        $mailer->SMTPDebug = false;
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = 465;
        $mailer->CharSet = 'UTF-8';
        $mailer->Host = 'smtp.gmail.com';
        $mailer->Username = $_ENV['MAILER_USERNAME'];
        $mailer->Password = $_ENV['MAILER_PASSWORD'];
        $mailer->isHTML(true);
    }

    public function send(Registration $registration, string $attachment = ''): bool
    {
        $mailer = new PHPMailer();
        $this->configure($mailer);
        try {
            $template = "<p>Name: {$registration->getName()}</p><p>CPF: {$registration->getNumber()}</p>";
            $mailer->addAddress($registration->getEmail());
            $mailer->setFrom($_ENV['MAILER_USERNAME'], 'School clean code');
            $mailer->Subject = 'Mail Registration';
            $mailer->addAttachment($attachment);
            $mailer->msgHTML($template);
            if(!$mailer->Send()) {
                throw new \DomainException('Mail not possible send');
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

}
