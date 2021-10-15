<?php


declare(strict_types=1);


namespace App\Application\UseCases\ExportRegistration;


use App\Domain\ValueObjects\Cpf;
use App\Application\Contracts\Storage;
use App\Application\Contracts\RegistrationPdfExport;
use App\Domain\Repositories\LoadRegistrationRepository;


final class ExportRegistration
{
    private Storage $storage;
    private RegistrationPdfExport $pdfExport;
    private LoadRegistrationRepository $repository;

    public function __construct(LoadRegistrationRepository $repository, RegistrationPdfExport $pdfExport, Storage $storage)
    {
        $this->storage = $storage;
        $this->pdfExport = $pdfExport;
        $this->repository = $repository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cpf = new Cpf($input->getCpf());
        $registration = $this->repository->loadByRegistrationNumber($cpf);

        $fileContent = $this->pdfExport->generate($registration);
        $this->storage->store($input->getFileName(), $input->getPath(), $fileContent);

        return new OutputBoundary($input->getPath() . DIRECTORY_SEPARATOR . $input->getFileName());
    }
}
