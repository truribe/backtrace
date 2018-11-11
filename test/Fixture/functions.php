<?php
/**
 * TODO Add @file block for functions.php
 *
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Fixture;

use tvanc\backtrace\Test\Fixture\ExceptionThrowingClass;
use tvanc\backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * @param string $message
 *
 * @throws ExceptionWithUnlikelyStringForName
 */
function foo (string $message) {
    bar($message);
}

/**
 * @param string $message
 *
 * @throws ExceptionWithUnlikelyStringForName
 */
function bar (string $message) {
    $class = new ExceptionThrowingClass();

    $class->throwException($message);
}
