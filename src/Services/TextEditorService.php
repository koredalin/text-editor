<?php

namespace App\Services;

use App\Models\InputArguments;
use App\Common\Commands;
use App\Services\FileService;

/**
 * Description of TextEditor
 *
 * @author Hristo
 */
final class TextEditorService
{
    private InputArguments $inputArguments;

    private FileService $fileService;

    public function __construct(
        InputArguments $inputArguments,
        FileService $fileService
    ) {
        $this->inputArguments = $inputArguments;
        $this->fileService = $fileService;
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
