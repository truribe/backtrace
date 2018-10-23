<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handler;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Handler\ErrorHandlerInterface;

/**
 * Just a convenience class for handler test cases to extend if they need the
 * same handler multiple times.
 */
abstract class AbstractHandlerTest extends TestCase implements HandlerTestInterface
{
    abstract public function getHandler(): ErrorHandlerInterface;
}
