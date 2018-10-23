<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Handler\EnvironmentAwareHandler;
use tvanc\backtrace\Test\Environment\TestEnvironment;

/**
 * Class EnvironmentAwareHandlerTest
 *
 * @see EnvironmentAwareHandler
 */
class EnvironmentAwareHandlerTest extends TestCase
{
    const ARBITRARY_WIDTH = 42;


    /**
     * Verify handler is as aware as it says it is.
     */
    public function testEnvironmentalAwareness()
    {
        /** @var EnvironmentAwareHandler|MockObject $awareHandler */
        // Create test environment set to non-CLI, non-AJAX.
        $env = new TestEnvironment(false, false);
        $awareHandler = new EnvironmentAwareHandler($env);

        $defaultHandler = new TestErrorHandler();
        $cliHandler = new TestErrorHandler();
        $ajaxHandler = new TestErrorHandler();

        $awareHandler->setDefaultHandler($defaultHandler);
        $awareHandler->setCliHandler($cliHandler);
        $awareHandler->setAjaxHandler($ajaxHandler);

        // Trigger default handler
        $awareHandler->catchThrowable(new \Exception(''));

        $this->assertTrue($defaultHandler->caughtThrowable());
        $this->assertFalse($cliHandler->caughtThrowable());
        $this->assertFalse($ajaxHandler->caughtThrowable());

        $defaultHandler->setCaughtThrowable(false);

        // // Trigger CLI handler
        $env->setIsCli(true);
        $awareHandler->catchThrowable(new \Exception(''));

        $this->assertFalse($defaultHandler->caughtThrowable());
        $this->assertTrue($cliHandler->caughtThrowable());
        $this->assertFalse($ajaxHandler->caughtThrowable());

        $cliHandler->setCaughtThrowable(false);

        // // Trigger AJAX handler
        $env->setIsCli(false);
        $env->setIsAjaxRequest(true);
        $awareHandler->catchThrowable(new \Exception(''));

        $this->assertFalse($defaultHandler->caughtThrowable());
        $this->assertFalse($cliHandler->caughtThrowable());
        $this->assertTrue($ajaxHandler->caughtThrowable());
    }
}
