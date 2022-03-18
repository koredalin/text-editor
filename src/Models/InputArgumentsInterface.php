<?php

namespace App\Models;

/**
 *
 * @author Hristo
 */
interface InputArgumentsInterface
{
    public function getIsEdit(): bool;
    
    public function getIsResultPrint(): bool;
    
    public function getCommand(): string;
    
    public function getCommandParameters(): array;
    
    public function getInputFilePath(): string;
}
