<?php


declare(strict_types=1);


namespace App\Infra\Cli\Commands;


use App\Infra\Http\Controllers\Presentation;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Application\UseCases\ExportRegistration\ExportRegistration;


final class ExportRegistrationCommand
{
    private ExportRegistration $useCase;

    public function __construct(ExportRegistration $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): string
    {
        $inputBoundary = new inputBoundary(
            '01234567890',
            'xpto.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        return $presentation->output(array(
            'fullFileName' => $output->getFullFileName()
        ));
    }
}
