<?php


declare(strict_types=1);


namespace App\Application\UseCases\ExportRegistration;


final class InputBoundary
{
    private string $cpf;
    private string $path;
    private string $fileName;

    public function __construct(string $cpf, string $fileName, string $path)
    {
        $this->cpf = $cpf;
        $this->path = $path;
        $this->fileName = $fileName;
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
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

}
