<?php

namespace App\Exceptions;

/**
 * Description of FileException
 *
 * @author Hristo
 */
class FileException extends \Exception
{
    /**
     * Construct the exception
     * <p>Constructs the Exception.</p>
     * @param string $message <p>The Exception message to throw.</p>
     * @param int $code <p>The Exception code.</p>
     * @param \Throwable $previous <p>The previous exception used for the exception chaining.</p>
     * @return self
     * @link https://php.net/manual/en/exception.construct.php
     * @since PHP 5, PHP 7, PHP 8
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = get_class() . '. ' . $message;
        $code = 422;
        parent::__construct($message, $code, $previous);
    }
}
