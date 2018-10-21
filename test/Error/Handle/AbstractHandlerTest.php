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
 * Class AbstractHandlerTest
 */
abstract class AbstractHandlerTest extends TestCase
{
    abstract public function getHandler(): ErrorHandlerInterface;


    abstract public function testCatchThrowable();


    abstract public function testHandleError();
}
