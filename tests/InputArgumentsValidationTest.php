<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\InputArguments;
use App\Common\Commands;
use App\Exceptions\NotValidInputException;

/**
 * Input Arguments Validation Test
 *
 * @author Hristo
 */
class InputArgumentsValidationTest extends TestCase
{
    private const DEFAULT_COMMAND = [
        'index.php',
        '\'s/hhh/ddd/\'',
        './resources/input.txt',
    ];
    
    private const CONFIG_PARAM_FILE_WRITE_COMMAND = [
        'index.php',
        '-i',
        '\'s/hhh/ddd/\'',
        './resources/input.txt',
    ];
    
    private const WRONG_CONFIG_PARAM_COMMAND = [
        'index.php',
        '-wrong_param',
        '\'s/hhh/ddd/\'',
        './resources/input.txt',
    ];
    
    private const NO_COMMAND = [
        'index.php'
    ];
    
    private const NO_COMMAND_HAS_QUOTES = [
        'index.php',
        '\'\'',
    ];
    
    private const CONFIG_PARAM_NO_COMMAND = [
        'index.php',
        '-i',
    ];
    
    private const CONFIG_PARAM_NO_COMMAND_HAS_QUOTES = [
        'index.php',
        '-i',
        '\'\'',
    ];
    
    private const NO_CONFIG_PARAMS_WRONG_COMMAND_NO_PARAMS = [
        'index.php',
        '\'wrong_command_no_params\'',
    ];
    
    private const NO_CONFIG_PARAMS_SUBSTITUTE_COMMAND_NO_PARAMS = [
        'index.php',
        '\'s/\'',
    ];
    
    private const COMMAND_WITHOUT_FILE_PATH = [
        'index.php',
        '\'s/hhh/ddd/\'',
    ];
    
    
    public function testOkNoConfigParam(): void
    {
        $args = $this->generateInputArgumentsInstance();
        $args->setCommandArguments(self::DEFAULT_COMMAND);
        
        $this->assertEquals(false, $args->getIsEdit());
        $this->assertEquals(true, $args->getIsResultPrint());
        $this->assertEquals(Commands::SUBSTITUTE, $args->getCommand());
        $this->assertEquals(['hhh', 'ddd', '', ], $args->getCommandParameters());
        $this->assertEquals('./resources/input.txt', $args->getInputFilePath());
    }
    
    public function testOkWithFileWriteConfigParam(): void
    {
        $args = $this->generateInputArgumentsInstance();
        $args->setCommandArguments(self::CONFIG_PARAM_FILE_WRITE_COMMAND);
        
        $this->assertEquals(true, $args->getIsEdit());
        $this->assertEquals(false, $args->getIsResultPrint());
        $this->assertEquals(Commands::SUBSTITUTE, $args->getCommand());
        $this->assertEquals(['hhh', 'ddd', '', ], $args->getCommandParameters());
        $this->assertEquals('./resources/input.txt', $args->getInputFilePath());
    }
    
    public function testInvalidConfigParam(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. Wrong input configuration parameter.');
        
        $args->setCommandArguments(self::WRONG_CONFIG_PARAM_COMMAND);
    }
    
    public function testNoCommand(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. The command need to be in single quotes.');
        
        $args->setCommandArguments(self::NO_COMMAND);
    }
    
    public function testNoCommandHasQuotes(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. No execution command argument.');
        
        $args->setCommandArguments(self::NO_COMMAND_HAS_QUOTES);
    }
    
    public function testWrongCommandHasQuotes(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. Unknown execution command: wrong_command_no_params.');
        
        $args->setCommandArguments(self::NO_CONFIG_PARAMS_WRONG_COMMAND_NO_PARAMS);
    }
    
    public function testSubstituteCommandNotEnoughParams(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. Not enough command parameters.');
        
        $args->setCommandArguments(self::NO_CONFIG_PARAMS_SUBSTITUTE_COMMAND_NO_PARAMS);
    }
    
    public function testSubstituteCommandWithoutInputFilePath(): void
    {
        $args = $this->generateInputArgumentsInstance();
        
        $this->expectException(NotValidInputException::class);
        $this->expectExceptionMessage('App\Exceptions\NotValidInputException. No input file path argument.');
        
        $args->setCommandArguments(self::COMMAND_WITHOUT_FILE_PATH);
    }
    
    private function generateInputArgumentsInstance(): InputArguments
    {
        return new InputArguments;
    }
}
