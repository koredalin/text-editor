<?php

namespace App\Services;

use App\Models\InputFileManager;

/**
 * Description of File
 *
 * @author Hristo
 */
final class FileService
{
    private InputFileManager $inputFile;

    public function __construct(InputFileManager $inputFile)
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
