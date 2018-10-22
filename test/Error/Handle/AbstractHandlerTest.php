<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handle;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Handle\ErrorHandlerInterface;

/**
 * Just a convenience class for handler test cases to extend if they need the
 * same handler multiple times.
 */
abstract class AbstractHandlerTest extends TestCase implements HandlerTestInterface
{
    abstract public function getHandler(): ErrorHandlerInterface;
}
