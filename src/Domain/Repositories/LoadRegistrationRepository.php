<?php


declare(strict_types=1);


namespace App\Domain\Repositories;


use App\Domain\ValueObjects\Cpf;
use App\Domain\Entities\Registration;


interface LoadRegistrationRepository
{
    public function loadByRegistrationNumber(Cpf $cpf): Registration;
}
