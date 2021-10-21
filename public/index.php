<?php

use Dotenv\Dotenv;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\PhpMailerAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Http\Controllers\MailRegistrationController;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;
use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Application\UseCases\MailRegistration\MailRegistration;
use App\Application\UseCases\ExportRegistration\ExportRegistration;

require_once __DIR__ . '/../vendor/autoload.php';
$appConfig = require_once __DIR__ . '/../config/app.php';

$dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
$dotEnv->safeLoad();

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

// Use Case Export Registration
$request = new Request('GET', 'http://localhost:8000');
$response = new Response();

$storage = new LocalStorageAdapter();
$pdfExporter = new Html2PdfAdapter();
$loadRegistrationRepository = new PdoRegistrationRepository($pdo);

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);
$exportRegistrationController = new ExportRegistrationController($request, $response, $exportRegistrationUseCase);

$exportRegistrationPresenter = new ExportRegistrationPresenter();
echo $exportRegistrationController->handle($exportRegistrationPresenter)->getBody();

echo '<br/>';

// Use Case Mail Registration
$request = new Request('GET', 'http://localhost:8000');
$response = new Response();

$mailerAdapter = new PhpMailerAdapter();

$mailRegistrationUseCase = new MailRegistration($loadRegistrationRepository, $mailerAdapter);
$mailRegistrationController = new MailRegistrationController($request, $response, $mailRegistrationUseCase);

$exportRegistrationPresenter = new ExportRegistrationPresenter();
echo $mailRegistrationController->handle($exportRegistrationPresenter)->getBody();
