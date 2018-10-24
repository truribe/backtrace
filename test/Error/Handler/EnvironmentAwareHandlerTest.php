<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Handler;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Error\Responder\EnvironmentAwareResponder;
use tvanc\backtrace\Test\Environment\TestEnvironment;

/**
 * Class EnvironmentAwareHandlerTest
 *
 * @see EnvironmentAwareResponder
 */
class EnvironmentAwareHandlerTest extends TestCase
{
    const ARBITRARY_WIDTH = 42;


    /**
     * Verify handler is as aware as it says it is.
     */
    public function testEnvironmentalAwareness()
    {
        // Create test environment set to non-CLI, non-AJAX.
        $env = new TestEnvironment(false, false);
        $awareHandler = new EnvironmentAwareResponder($env);

        $defaultHandler = new TestErrorResponder();
        $cliHandler = new TestErrorResponder();
        $ajaxHandler = new TestErrorResponder();

        $awareHandler->setDefaultHandler($defaultHandler);
        $awareHandler->setCliHandler($cliHandler);
        $awareHandler->setAjaxHandler($ajaxHandler);

        // Trigger default handler
        $awareHandler->handleException(new \Exception(''));

        $this->assertTrue($defaultHandler->caughtThrowable());
        $this->assertFalse($cliHandler->caughtThrowable());
        $this->assertFalse($ajaxHandler->caughtThrowable());

        $defaultHandler->setCaughtThrowable(false);

        // // Trigger CLI handler
        $env->setIsCli(true);
        $awareHandler->handleException(new \Exception(''));

        $this->assertFalse($defaultHandler->caughtThrowable());
        $this->assertTrue($cliHandler->caughtThrowable());
        $this->assertFalse($ajaxHandler->caughtThrowable());

        $cliHandler->setCaughtThrowable(false);

        // // Trigger AJAX handler
        $env->setIsCli(false);
        $env->setIsAjaxRequest(true);
        $awareHandler->handleException(new \Exception(''));

        $this->assertFalse($defaultHandler->caughtThrowable());
        $this->assertFalse($cliHandler->caughtThrowable());
        $this->assertTrue($ajaxHandler->caughtThrowable());
    }
}
