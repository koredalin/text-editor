<?php

namespace App\Services;

use App\Models\InputArguments;
use App\Services\FileService;
use App\Services\ConsoleService;

/**
 * Description of OutputService
 *
 * @author Hristo
 */
final class OutputService
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

    /**
     * Outputs the parameter text as the command output configuration parameters.
     *
     * @param string $text
     * @return void
     */
    public function produceOutput(string $text): void
    {
        if ($this->inputArguments->getIsFileEdit()) {
            $this->fileService->setFileText($text);
        }

        if ($this->inputArguments->getIsResultPrint()) {
            $this->consoleService->printText($text);
        }
    }
}
