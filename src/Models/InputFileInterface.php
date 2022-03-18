<?php

namespace App\Models;

/**
 *
 * @author Hristo
 */
interface InputFileInterface
{
    public function getFileText(): string;
    public function setFileText(): string;
}
