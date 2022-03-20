<?php

require_once './vendor/autoload.php';
require_once './config/config.php';

use App\Models\InputArguments;
use App\Models\InputFileManager;
use App\Services\TextEditorService;
use App\Services\FileService;
use App\Services\ConsoleService;
use App\TextEditorController;
use App\Services\OutputService;

$inputArguments = new InputArguments();
$inputFileManager = new InputFileManager();
$consoleService = new ConsoleService();
$fileService = new FileService($inputFileManager);
$textEditorService = new TextEditorService($inputArguments, $fileService);
$outputService = new OutputService($inputArguments, $fileService, $consoleService);
$controller = new TextEditorController($inputArguments, $inputFileManager, $textEditorService, $outputService);
$controller->execute($argv);