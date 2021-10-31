<?php


declare(strict_types=1);


namespace App\Domain\Exceptions;


use Throwable;


class CpfInvalidException extends \DomainException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "CPF is not valid";
        parent::__construct($message, $code, $previous);
    }
}
