<?php

use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Cli\Commands\ExportRegistrationCommand;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;
use App\Application\UseCases\ExportRegistration\ExportRegistration;

require_once __DIR__ . '/../vendor/autoload.php';

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

$storage = new LocalStorageAdapter();
$pdfExporter = new Html2PdfAdapter();
$loadRegistrationRepository = new PdoRegistrationRepository($pdo);

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExporter, $storage);

$exportRegistrationCommand = new ExportRegistrationCommand($exportRegistrationUseCase);

$exportRegistrationPresenter = new ExportRegistrationPresenter();
echo $exportRegistrationCommand->handle($exportRegistrationPresenter);
