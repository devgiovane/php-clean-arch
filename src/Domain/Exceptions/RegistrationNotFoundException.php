<?php


declare(strict_types=1);


namespace App\Domain\Exceptions;


use Exception;
use Throwable;
use App\Domain\ValueObjects\Cpf;


class RegistrationNotFoundException extends Exception
{
    public function __construct(Cpf $cpf, $code = 0, Throwable $previous = null)
    {
        $message = "CPF {$cpf} not found";
        parent::__construct($message, $code, $previous);
    }
}
