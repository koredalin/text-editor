<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Models\InputFileManager;
use App\Exceptions\NotValidInputFileException;

/**
 * Input File Test
 *
 * @author Hristo
 */
class InputFileTest extends TestCase
{
    private const DEFAULT_FILE_PATH = __DIR__ . '/../resources/input.txt';
    private const NON_EXISTING_FILE_PATH = __DIR__ . '/../resources/non_existing_file.txt';
    
    private const DEFAULT_FILE_TEXT = 'fdasfa hhh afeafaafae hhh awegfafra hhhh dafeawfeas hhh afewafeafwearfgh';
    private const FILE_TEXT1 = 'Text variant 1.';
    private const FILE_TEXT2 = 'Text variant 2.';
    
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
    
    
    public function testOkFileReadableWriteable(): void
    {
        self::generateDefaultInputFile();
        
        // Test assertion 1
        $this->assertEquals(self::DEFAULT_FILE_TEXT, file_get_contents(self::DEFAULT_FILE_PATH));
        
        $file = self::generateInputFileManagerInstance();
        $file->setFileText(self::DEFAULT_FILE_PATH);
        
        // Test assertion 2
        $file->setFileText(self::FILE_TEXT1);
        $this->assertEquals(self::FILE_TEXT1, $file->getFileText());
        // Test assertion 3
        $file->setFileText(self::FILE_TEXT2);
        $this->assertEquals(self::FILE_TEXT2, $file->getFileText());
    }
    
    public function testNoInputFile(): void
    {
        if (file_exists(self::NON_EXISTING_FILE_PATH)) {
            unlink(self::NON_EXISTING_FILE_PATH);
        }
        
        $file = self::generateInputFileManagerInstance();
        
        // Test assertion 1
        $this->expectException(NotValidInputFileException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputFileException::class . '. No file with file path: \'' . self::NON_EXISTING_FILE_PATH . '\'.');
        
        $file->setInputFilePath(self::NON_EXISTING_FILE_PATH);
    }
}
