<?php

namespace App\Models;

/**
 *
 * @author Hristo
 */
interface InputFileInterface
{
    public function getInputFilePath(): string;
    public function getFileText(): string;
    public function setFileText(string $text): string;
}
