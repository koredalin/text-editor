<?php

namespace App\Services;

final class ConsoleService
{
    public function printText(string $text): void
    {
        echo $text;
    }
}