<?php


declare(strict_types=1);


namespace App\Application\UseCases\ExportRegistration;


final class OutputBoundary
{
    private string $fullFileName;

    /**
     * @param string $fullFileName
     */
    public function __construct(string $fullFileName)
    {
        $this->fullFileName = $fullFileName;
    }

    /**
     * @return string
     */
    public function getFullFileName(): string
    {
        return $this->fullFileName;
    }

}
