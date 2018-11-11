<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Test\Fixture;

use tvanc\Backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * This class exists just to ensure that a class-method frame exists
 * in the backtrace.
 */
class ExceptionThrowingClass
{
    public function throwException(string $message)
    {
        throw new ExceptionWithUnlikelyStringForName($message);
    }
}
