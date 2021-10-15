<?php


declare(strict_types=1);


namespace App\Infra\Adapters;


use Spipu\Html2Pdf\Html2Pdf;
use App\Domain\Entities\Registration;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use App\Application\Contracts\RegistrationPdfExport;


final class Html2PdfAdapter implements RegistrationPdfExport
{
    public function generate(Registration $registration): string
    {
        $html2pdf = new Html2Pdf('P', 'A4');

        try {
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML("<p>Name: {$registration->getName()}</p><p>CPF: {$registration->getNumber()}</p>");
            return $html2pdf->output('', 'S');
        } catch (Html2PdfException $exception) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($exception);
            echo $formatter->getHtmlMessage();
            return '';
        }
    }
}
