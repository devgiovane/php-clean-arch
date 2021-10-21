<?php


declare(strict_types=1);


namespace App\Infra\Http\Controllers;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Application\UseCases\MailRegistration\InputBoundary;
use App\Application\UseCases\MailRegistration\MailRegistration;


final class MailRegistrationController
{
    private RequestInterface $request;
    private ResponseInterface $response;
    private MailRegistration $useCase;

    public function __construct(RequestInterface $request, ResponseInterface $response, MailRegistration $useCase)
    {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): ResponseInterface
    {
        $inputBoundary = new InputBoundary(
            '01234567890',
            __DIR__ . '/../../../../storage/registrations/student.pdf'
        );

        $output = $this->useCase->handle($inputBoundary);

        $this->response
            ->getBody()
            ->write($presentation->output(array(
                'email' => $output->getEmail()
            )));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
