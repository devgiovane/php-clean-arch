<?php


declare(strict_types=1);


namespace App\Application\Contracts;


use App\Domain\Entities\Registration;


interface RegistrationMailer
{
    public function send(Registration  $registration, string $attachment): bool;
}
