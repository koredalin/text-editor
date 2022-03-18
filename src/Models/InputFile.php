<?php

namespace App\Models;

use App\Models\InputFileInterface;
use App\Exceptions\NotValidInputFileException;

/**
 * Description of InputFile
 *
 * @author Hristo
 */
class InputFile implements InputFileInterface
{
    private string $inputFilePath;

    public function __construct(string $inputFilePath)
    {
        $this->inputFilePath = $inputFilePath;
        $this->validateInputFile();
    }
    
    
    public function getInputFilePath(): string
    {
        return $this->inputFilePath;
    }
    
    public function getFileText(): string
    {
        return file_get_contents($this->inputFilePath);
    }
    
    public function setFileText(string $text): void
    {
        file_put_contents($this->inputFilePath, $text);
    }
    
    private function validateInputFile(): void
    {
        if (!file_exists($this->inputFilePath) || !is_file($this->inputFilePath)) {
            throw new NotValidInputFileException('No file with file path: ' . $this->inputFilePath . '.');
        }
        
        if (!'text/plain' === mime_content_type($this->inputFilePath)) {
            throw new NotValidInputFileException('The input file is not in text format.');
        }
    }
}
