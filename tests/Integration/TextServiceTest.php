<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Models\InputArguments;
use App\Models\InputFileManager;
use App\Exceptions\NotValidInputFileException;
use App\Services\TextEditorService;
use App\Services\FileService;
use App\Services\ConsoleService;

/**
 * Text Service Test
 *
 * @author Hristo
 */
class TextServiceTest extends TestCase
{
    private const DEFAULT_FILE_PATH = __DIR__ . '/../resources/input.txt';
    private const NON_EXISTING_FILE_PATH = __DIR__ . '/../resources/non_existing_file.txt';
    
    private const DEFAULT_FILE_TEXT = 'fdasfa hhh afeafaafae hhh awegfafra hhhh dafeawfeas hhh afewafeafwearfgh';
    private const EXPECTED_TEXT = 'fdasfa ddd afeafaafae ddd awegfafra dddh dafeawfeas ddd afewafeafwearfgh';
    
    private const DEFAULT_COMMAND = [
        'index.php',
        '\'s/hhh/ddd/\'',
        self::DEFAULT_FILE_PATH,
    ];
    
    private const CONFIG_PARAM_FILE_WRITE_COMMAND = [
        'index.php',
        '-i',
        '\'s/hhh/ddd/\'',
        self::DEFAULT_FILE_PATH,
    ];
    
    private static function generateInputArgumentsInstance(): InputArguments
    {
        return new InputArguments();
    }
    
    private static function generateInputFileManagerInstance(): InputFileManager
    {
        $file = new InputFileManager();
        $file->setInputFilePath(self::DEFAULT_FILE_PATH);
        
        return $file;
    }
    
    private static function generateDefaultInputFile(): void
    {
        $isRecordedFile = file_put_contents(self::DEFAULT_FILE_PATH, self::DEFAULT_FILE_TEXT);
        if (false === $isRecordedFile) {
            throw new \Exception(get_class().'. Not generated input file.');
        }
    }
    
    private static function generateTextEditor(array $inputArguments): TextEditorService
    {
        self::generateDefaultInputFile();
        $args = self::generateInputArgumentsInstance();
        $args->setCommandArguments($inputArguments);
        $file = self::generateInputFileManagerInstance();
        $fileService = new FileService($file);
        $consoleService = new ConsoleService();
        $editor = new TextEditorService($args, $fileService, $consoleService);
            
        return $editor;
    }
    
    
    public function testOkUpdatedFile(): void
    {
        $editor = self::generateTextEditor(self::CONFIG_PARAM_FILE_WRITE_COMMAND);
        $editor->action();
        
        // Test assertion 1
        $this->assertEquals(self::EXPECTED_TEXT, file_get_contents(self::DEFAULT_FILE_PATH));
    }
    
    public function testOkPrintUpdatedText(): void
    {
        $editor = self::generateTextEditor(self::DEFAULT_COMMAND);
        $editor->action();
        
        // Test assertion 1
        $this->assertEquals(self::DEFAULT_FILE_TEXT, file_get_contents(self::DEFAULT_FILE_PATH));
        // Test assertion 2
        $this->expectOutputString(self::EXPECTED_TEXT, file_get_contents(self::DEFAULT_FILE_PATH));
    }
}
