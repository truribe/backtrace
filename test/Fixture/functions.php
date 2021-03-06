<?php
/**
 * @file Declares functions to be used in test cases that need non-method
 * functions in their backtrace to achieve full coverage.
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Fixture;

use TVanC\Backtrace\Test\Fixture\ExceptionThrowingClass;
use TVanC\Backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * @param string $message
 *
 * @throws ExceptionWithUnlikelyStringForName
 */
function foo(string $message)
{
    bar($message);
}

/**
 * @param string $message
 *
 * @throws ExceptionWithUnlikelyStringForName
 */
function bar(string $message)
{
    $class = new ExceptionThrowingClass();

    $class->throwException($message);
}
