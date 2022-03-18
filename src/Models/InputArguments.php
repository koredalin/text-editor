<?php

namespace App\Models;

use App\Common\Commands;
use App\Common\StreamConfiguration;
use App\Exceptions\NotValidInputException;

/**
 * Description of InputArguments
 *
 * @author Hristo
 */
final class InputArguments
{
    private array $commandArguments;
    
    private bool $isEdit;
    
    private bool $isResultPrint;
    
    private bool $isConfigurationParameter;
    
    private string $command;
    
    private array $commandParameters;
    
    private string $inputFilePath;
    
    public function setCommandArguments(array $commandArguments)
    {
        $this->commandArguments = $commandArguments;
        $this->setDefaultProperties();
        $this->setProperties();
    }
    
    public function getIsEdit(): bool
    {
        return $this->isEdit;
    }
    
    public function getIsResultPrint(): bool
    {
        return $this->isResultPrint;
    }
    
    public function getCommand(): string
    {
        return $this->command;
    }
    
    public function getCommandParameters(): array
    {
        return $this->commandParameters;
    }
    
    public function getInputFilePath(): string
    {
        return $this->inputFilePath;
    }
    
    private function setDefaultProperties(): void
    {
        $this->isEdit = false;
        $this->isResultPrint = true;
        $this->isConfigurationParameter = false;
        $this->command = '';
        $this->commandParameters = [];
        $this->inputFilePath = '';
    }
    
    private function setProperties(): void
    {
        $this->setConfigurationParameters();
        $this->setCommandWithParameters();
        $this->setInputFilePath();
    }
    
    private function setConfigurationParameters(): void
    {
        $isParameter = isset($this->commandArguments[1]) && in_array((string)$this->commandArguments[1], StreamConfiguration::ALL_PARAMETERS, true);
        if (!$isParameter) {
            return;
        }
        
        $this->isConfigurationParameter = true;
        $parameter = (string)$this->commandArguments[1];
        if ($isParameter && $parameter === StreamConfiguration::EDIT_IN_PLACE) {
            $this->isEdit = true;
            $this->isResultPrint = false;
        }
    }
    
    private function setCommandWithParameters(): void
    {
        $firstArgument = !$this->isConfigurationParameter && isset($this->commandArguments[1]) ? explode('/', $this->commandArguments[1]) : [];
        $secondArgument = $this->isConfigurationParameter && isset($this->commandArguments[2]) ? explode('/', $this->commandArguments[2]) : [];
        if (empty($firstArgument) && empty($secondArgument)) {
            throw new NotValidInputException('No execution command argument.');
        }
        
        $commandArr = 0 < count($firstArgument) ? $firstArgument : $secondArgument;
        if (!in_array((string)$commandArr[0], Commands::ALL_COMMANDS, true)) {
            throw new NotValidInputException('Unknown execution command: ' . (string)$commandArr[0] . '.');
        }
        
        $this->command = (string)$commandArr[0];
        array_shift($commandArr);
        $this->setCommandParameters($commandArr);
    }
    
    private function setCommandParameters(array $commandParameters): void
    {
        if ($this->command === Commands::SUBSTITUTE && 2 > count($commandParameters)) {
            throw new NotValidInputException('Not enough command parameters.');
        }
        
        foreach ($commandParameters as $param) {
            $this->commandParameters[] = (string)$param;
        }
        
        if (
            $this->command === Commands::SUBSTITUTE
            && (2 > count($this->commandParameters) || '' === $this->commandParameters[0])
        ) {
            throw new NotValidInputException('Not enough command parameters');
        }
    }
    
    private function setInputFilePath()
    {
        $secondArgument = !$this->isConfigurationParameter && isset($this->commandArguments[2]) ? (string)$this->commandArguments[2] : '';
        $thirdArgument = $this->isConfigurationParameter && isset($this->commandArguments[3]) ? (string)$this->commandArguments[3] : '';
        if ('' === $secondArgument && '' === $thirdArgument) {
            throw new NotValidInputException('No input file path argument.');
        }
        
        $this->inputFilePath = '' === $secondArgument ? $thirdArgument : $secondArgument;
    }
}
