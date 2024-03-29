<?php


declare(strict_types=1);


namespace App\Infra\Presentation;


final class ExportRegistrationPresenter implements Presentation
{
    public function output(array $data): string
    {
        return json_encode($data);
    }
}
