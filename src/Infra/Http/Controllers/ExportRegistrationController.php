<?php


declare(strict_types=1);


namespace App\Infra\Http\Controllers;


use App\Infra\Presentation\Presentation;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Infra\Http\Notification\NotificationError;
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
        $notificationError = new NotificationError();

        $body = json_decode($this->request->getBody()->getContents(), true);

        if(empty($body['cpf'])) {
            $notificationError
                ->setMessage(array('error' => 'CPF is not empty'))
                ->setStatusCode(400);
        } else {
            $inputBoundary = new inputBoundary(
                $body['cpf'],
                $body['cpf'] . '.pdf',
                __DIR__ . '/../../../../storage/registrations'
            );

            try {
                $output = $this->useCase->handle($inputBoundary);

                $notificationError
                    ->setMessage(array('fullFileName' => $output->getFullFileName()))
                    ->setStatusCode(200);
            } catch (\Exception $exception) {
                $notificationError
                    ->setMessage(array('error' => $exception->getMessage()))
                    ->setStatusCode(400);
            }
        }

        $this->response
            ->getBody()
            ->write($presentation->output($notificationError->getMessage()));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($notificationError->getStatusCode());
    }
}
