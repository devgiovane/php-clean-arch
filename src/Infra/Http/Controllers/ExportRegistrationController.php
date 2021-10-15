<?php


declare(strict_types=1);


namespace App\Infra\Http\Controllers;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Application\UseCases\ExportRegistration\ExportRegistration;


final class ExportRegistrationController
{
    private RequestInterface $request;
    private ResponseInterface $response;
    private ExportRegistration  $useCase;

    public function __construct(RequestInterface $request, ResponseInterface $response, ExportRegistration $useCase)
    {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): ResponseInterface
    {
        $inputBoundary = new inputBoundary(
            '01234567890',
            'xpto.pdf',
            __DIR__ . '/../../../../storage/registrations'
        );

        $output = $this->useCase->handle($inputBoundary);

        $this->response
            ->getBody()
            ->write( $presentation->output(array(
                'fullFileName' => $output->getFullFileName()
            )));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
