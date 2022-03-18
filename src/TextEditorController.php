<?php

namespace App;

use App\Models\InputArguments;
use App\Models\InputFileManager;
use App\Services\TextEditorService;
// Exceptions
use Exception;
use App\Exceptions\NotValidInputException;
use App\Exceptions\NotValidInputFileException;

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
    
    public function __construct(
        InputArguments $inputArguments,
        InputFileManager $inputFileManager,
        TextEditorService $textEditorService
    ) {
        $this->inputArguments = $inputArguments;
        $this->inputFileManager = $inputFileManager;
        $this->textEditorService = $textEditorService;
    }
    
    public function execute(): void
    {
        try {
            global $argv;
            $this->inputArguments->setCommandArguments($argv);
            $this->inputFileManager->setInputFilePath($this->inputArguments->getInputFilePath());
            $this->textEditorService->action();
        } catch (NotValidInputException | NotValidInputFileException | Exception $ex) {
            echo $ex;
            return;
        }
    }
}
