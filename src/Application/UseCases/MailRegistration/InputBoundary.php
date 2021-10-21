<?php


declare(strict_types=1);


namespace App\Application\UseCases\MailRegistration;


final class InputBoundary
{
    private string $cpf;
    private string $attachment;

    /**
     * @param string $cpf
     * @param string $attachment
     */
    public function __construct(string $cpf, string $attachment)
    {
        $this->cpf = $cpf;
        $this->attachment = $attachment;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->attachment;
    }

}
