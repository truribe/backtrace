<?php
/**
 * TODO Add @file block for ExceptionThrowingClass.php
 *
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Fixture;

use tvanc\backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * TODO Document ExceptionThrowingClass
 */
class ExceptionThrowingClass
{
    public function throwException(string $message)
    {
        throw new ExceptionWithUnlikelyStringForName($message);
    }
}
