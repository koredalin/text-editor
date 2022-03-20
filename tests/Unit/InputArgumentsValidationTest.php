<?php

declare(strict_types=1);

namespace Tests\Unit;

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
    private const DEFAULT_FILE_PATH = __DIR__ . '/../resources/input.txt';

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

    private const WRONG_CONFIG_PARAM_COMMAND = [
        'index.php',
        '-wrong_param',
        '\'s/hhh/ddd/\'',
        self::DEFAULT_FILE_PATH,
    ];

    private const NO_COMMAND = [
        'index.php'
    ];

    private const NO_COMMAND_HAS_QUOTES = [
        'index.php',
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

    private static function generateInputArgumentsInstance(): InputArguments
    {
        return new InputArguments();
    }


    public function testOkNoConfigParam(): void
    {
        $args = self::generateInputArgumentsInstance();
        $args->setCommandArguments(self::DEFAULT_COMMAND);

        // Test assertion 1
        $this->assertEquals(false, $args->getIsFileEdit());
        // Test assertion 2
        $this->assertEquals(true, $args->getIsResultPrint());
        // Test assertion 3
        $this->assertEquals(Commands::SUBSTITUTE, $args->getCommand());
        // Test assertion 4
        $this->assertEquals(['hhh', 'ddd', '', ], $args->getCommandParameters());
        // Test assertion 5
        $this->assertEquals(self::DEFAULT_FILE_PATH, $args->getInputFilePath());
    }

    public function testOkWithFileWriteConfigParam(): void
    {
        $args = self::generateInputArgumentsInstance();
        $args->setCommandArguments(self::CONFIG_PARAM_FILE_WRITE_COMMAND);

        // Test assertion 1
        $this->assertEquals(true, $args->getIsFileEdit());
        // Test assertion 2
        $this->assertEquals(false, $args->getIsResultPrint());
        // Test assertion 3
        $this->assertEquals(Commands::SUBSTITUTE, $args->getCommand());
        // Test assertion 4
        $this->assertEquals(['hhh', 'ddd', '', ], $args->getCommandParameters());
        // Test assertion 5
        $this->assertEquals(self::DEFAULT_FILE_PATH, $args->getInputFilePath());
    }

    public function testInvalidConfigParam(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class . '. Wrong input configuration parameter.');

        $args->setCommandArguments(self::WRONG_CONFIG_PARAM_COMMAND);
    }

    public function testNoCommand(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class . '. The command need to be in single quotes.');

        $args->setCommandArguments(self::NO_COMMAND);
    }

    public function testNoCommandHasQuotes(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class . '. No execution command argument.');

        $args->setCommandArguments(self::NO_COMMAND_HAS_QUOTES);
    }

    public function testWrongCommandHasQuotes(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class
            . '. Unknown execution command: wrong_command_no_params.');

        $args->setCommandArguments(self::NO_CONFIG_PARAMS_WRONG_COMMAND_NO_PARAMS);
    }

    public function testSubstituteCommandNotEnoughParams(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class . '. Not enough command parameters.');

        $args->setCommandArguments(self::NO_CONFIG_PARAMS_SUBSTITUTE_COMMAND_NO_PARAMS);
    }

    public function testSubstituteCommandWithoutInputFilePath(): void
    {
        $args = self::generateInputArgumentsInstance();

        // Test assertion 1
        $this->expectException(NotValidInputException::class);
        // Test assertion 2
        $this->expectExceptionMessage(NotValidInputException::class . '. No input file path argument.');

        $args->setCommandArguments(self::COMMAND_WITHOUT_FILE_PATH);
    }
}
