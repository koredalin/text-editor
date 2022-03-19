<?php

namespace App\Models;

use App\Exceptions\NotValidInputFileException;
use App\Exceptions\FileException;

/**
 * Description of InputFile
 *
 * @author Hristo
 */
final class InputFileManager
{
    private string $inputFilePath;
    
    public function getInputFilePath(): string
    {
        return $this->inputFilePath;
    }

    public function setInputFilePath(string $inputFilePath): void
    {
        $this->inputFilePath = $inputFilePath;
        $this->validateInputFile();
    }
    
    public function getFileText(): string
    {
        $result = file_get_contents($this->inputFilePath);
        if (false === $result) {
            throw new FileException(get_class().'. No data extracted from the input file.');
        }
        
        return $result;
    }
    
    public function setFileText(string $text): void
    {
        $isRecordedFile = file_put_contents($this->inputFilePath, $text);
        if (false === $isRecordedFile) {
            throw new FileException(get_class().'. Not generated input file.');
        }
    }
    
    private function validateInputFile(): void
    {
        if (!file_exists($this->inputFilePath) || !is_file($this->inputFilePath)) {
            throw new NotValidInputFileException('No file with file path: \'' . $this->inputFilePath . '\'.');
        }
        
        if (!'text/plain' === mime_content_type($this->inputFilePath)) {
            throw new NotValidInputFileException('The input file is not in text format.');
        }
    }
}
