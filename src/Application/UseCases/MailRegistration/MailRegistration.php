<?php


declare(strict_types=1);


namespace App\Application\UseCases\MailRegistration;


use App\Domain\ValueObjects\Cpf;
use App\Application\Contracts\RegistrationMailer;
use App\Domain\Repositories\LoadRegistrationRepository;


final class MailRegistration
{
    private RegistrationMailer $mailer;
    private LoadRegistrationRepository $repository;

    public function __construct(LoadRegistrationRepository $repository, RegistrationMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->repository = $repository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cpf = new Cpf($input->getCpf());
        $registration = $this->repository->loadByRegistrationNumber($cpf);

        $this->mailer->send($registration, $input->getAttachment());
        return new OutputBoundary($registration->getEmail()->value());
    }
}
