<?php

namespace App\Services;

use App\Models\InputFileInterface;

/**
 * Description of File
 *
 * @author Hristo
 */
class File
{
    private InputFileInterface $inputFile;
    
    public function __construct(InputFileInterface $inputFile)
    {
        $this->inputFile = $inputFile;
    }
    
    public function readFileText(): string
    {
        return $this->inputFile->getFileText();
    }
    
    public function setFileText(string $text): void
    {
        $this->inputFile->setFileText($text);
    }
}
