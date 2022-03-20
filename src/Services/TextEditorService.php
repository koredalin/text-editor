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

    /**
     * Estimates the new text if the command exists.
     * Returns the result.
     *
     * @return string
     */
    public function updateText(): string
    {
        if (Commands::SUBSTITUTE === $this->inputArguments->getCommand()) {
            return $this->replaceFileText();
        }

        // This exception should not be thrown in general.
        // The exception should be already thrown in the InputArguments model.
        throw new \Exception('No valid text change command found.');
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

    /**
     * Extracts the text from the input file.
     * Replace it by the command.
     * Does not change the file.
     * Returns the updated text.
     *
     * @return string
     */
    private function replaceFileText(): string
    {
        $text = $this->fileService->readFileText();
        $commandParams = $this->inputArguments->getCommandParameters();
        $newText = str_replace((string)$commandParams[0], (string)$commandParams[1], $text);

        return $newText;
    }
}
