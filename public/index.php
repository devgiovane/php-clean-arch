<?php

use Dotenv\Dotenv;
use PlugRoute\PlugRoute;
use PlugRoute\RouteFactory;
use PlugRoute\Http\Request;
use PlugRoute\Http\Response;
use App\Infra\Adapters\PhpMailerAdapter;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\PlugRoutePsrAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;
use App\Infra\Http\Controllers\MailRegistrationController;
use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Application\UseCases\MailRegistration\MailRegistration;
use App\Application\UseCases\ExportRegistration\ExportRegistration;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->safeLoad();

$appConfig = require_once __DIR__ . '/../config/app.php';
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $appConfig['database']['host'],
    $appConfig['database']['port'],
    $appConfig['database']['name'],
    $appConfig['database']['charset']
);

$pdo = new \PDO($dsn, $appConfig['database']['username'], $appConfig['database']['password'], array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => TRUE
));

$route = RouteFactory::create();

$route->group(array('prefix' => '/api'), function (PlugRoute $route) use ($pdo) {

    $route->post('/registration/register', function (Request $request, Response $response) use ($pdo) {
        $newRequest = PlugRoutePsrAdapter::adapterRequest($request);
        $newResponse = PlugRoutePsrAdapter::adapterResponse($response);

        $storage = new LocalStorageAdapter();
        $pdfExporter = new Html2PdfAdapter();
        $exportRegistrationPresenter = new ExportRegistrationPresenter();
        $loadRegistrationRepository = new PdoRegistrationRepository($pdo);

        $exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);
        $exportRegistrationController = new ExportRegistrationController($newRequest, $newResponse, $exportRegistrationUseCase);

        $controllerResponse = $exportRegistrationController->handle($exportRegistrationPresenter);
        $responseAsArray = json_decode($controllerResponse->getBody(), true);

        return $response
            ->setStatusCode($controllerResponse->getStatusCode())
            ->addHeaders($controllerResponse->getHeaders())
            ->response()
            ->json($responseAsArray);
    });

    $route->post('/registration/email', function (Request $request, Response $response) use ($pdo) {
        $newRequest = PlugRoutePsrAdapter::adapterRequest($request);
        $newResponse = PlugRoutePsrAdapter::adapterResponse($response);

        $mailerAdapter = new PhpMailerAdapter();
        $exportRegistrationPresenter = new ExportRegistrationPresenter();
        $loadRegistrationRepository = new PdoRegistrationRepository($pdo);

        $mailRegistrationUseCase = new MailRegistration($loadRegistrationRepository, $mailerAdapter);
        $mailRegistrationController = new MailRegistrationController($newRequest, $newResponse, $mailRegistrationUseCase);

        $controllerResponse = $mailRegistrationController->handle($exportRegistrationPresenter);
        $responseAsArray = json_decode($controllerResponse->getBody(), true);

        return $response
            ->setStatusCode($controllerResponse->getStatusCode())
            ->addHeaders($controllerResponse->getHeaders())
            ->response()
            ->json($responseAsArray);
    });

});

$route->on();
