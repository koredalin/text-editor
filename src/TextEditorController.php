<?php

namespace App;

use App\Models\InputArguments;
use App\Models\InputFileManager;
use App\Services\TextEditorService;
use App\Services\OutputService;
// Exceptions
use Exception;
use App\Exceptions\NotValidInputException;
use App\Exceptions\NotValidInputFileException;
use App\Exceptions\FileException;

/**
 * Description of TextEditorController
 *
 * @author Hristo
 */
class TextEditorController
{
    private InputArguments $inputArguments;
    private InputFileManager $inputFileManager;
    private TextEditorService $textEditorService;
    private OutputService $outputService;

    public function __construct(
        InputArguments $inputArguments,
        InputFileManager $inputFileManager,
        TextEditorService $textEditorService,
        OutputService $outputService
    ) {
        $this->inputArguments = $inputArguments;
        $this->inputFileManager = $inputFileManager;
        $this->textEditorService = $textEditorService;
        $this->outputService = $outputService;
    }

    public function execute(array $commandArguments): void
    {
        try {
            $this->inputArguments->setCommandArguments($commandArguments);
            $this->inputFileManager->setInputFilePath($this->inputArguments->getInputFilePath());
            $newText = $this->textEditorService->updateText();
            $this->outputService->produceOutput($newText);
        } catch (NotValidInputException | NotValidInputFileException | FileException | Exception $ex) {
            echo $ex->getMessage();
            return;
        }
    }
}
