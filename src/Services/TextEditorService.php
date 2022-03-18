<?php

namespace App\Services;

use App\Models\InputArguments;
use App\Common\Commands;
use App\Services\FileService;
use App\Services\ConsoleService;

/**
 * Description of TextEditor
 *
 * @author Hristo
 */
final class TextEditorService
{
    private InputArguments $inputArguments;
    
    private FileService $fileService;
    
    private ConsoleService $consoleService;
    
    public function __construct(
        InputArguments $inputArguments,
        FileService $fileService,
        ConsoleService $consoleService
    ) {
        $this->inputArguments = $inputArguments;
        $this->fileService = $fileService;
        $this->consoleService = $consoleService;
    }
    
    public function action(): void
    {
        if (Commands::SUBSTITUTE === $this->inputArguments->getCommand()) {
            $this->replaceFileText();
        }
    }
    
    private function replaceFileText(): void
    {
        $text = $this->fileService->readFileText();
        $commandParams = $this->inputArguments->getCommandParameters();
        $newText = str_replace((string)$commandParams[0], (string)$commandParams[1], $text);
        if ($this->inputArguments->getIsEdit()) {
            $this->fileService->setFileText($newText);
        }
        
        if ($this->inputArguments->getIsResultPrint()) {
            $this->consoleService->printText($newText);
        }
    }
}
