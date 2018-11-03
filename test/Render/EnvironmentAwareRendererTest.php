<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Error\Responder;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Render\EnvironmentAwareRenderer;
use tvanc\backtrace\Test\Environment\TestEnvironment;
use tvanc\backtrace\Test\Render\TestExceptionRenderer;

/**
 * Test renderer's environmental awareness.
 */
class EnvironmentAwareRendererTest extends TestCase
{
    const ARBITRARY_WIDTH = 42;


    /**
     * Verify responder is as aware as it says it is. =O
     */
    public function testEnvironmentalAwareness()
    {
        /** @var EnvironmentAwareRenderer|MockObject $awareRenderer */
        // Create test environment set to non-CLI, non-AJAX.
        $env = new TestEnvironment(false, false);

        $defaultRenderer = new TestExceptionRenderer();
        $cliRenderer     = new TestExceptionRenderer();
        $ajaxRenderer    = new TestExceptionRenderer();
        $awareRenderer   = new EnvironmentAwareRenderer(
            $env,
            $cliRenderer,
            $ajaxRenderer,
            $defaultRenderer
        );

        // Trigger default responder
        $awareRenderer->render(new \Exception(''));

        $this->assertTrue($defaultRenderer->isRendered());
        $this->assertFalse($cliRenderer->isRendered());
        $this->assertFalse($ajaxRenderer->isRendered());

        $defaultRenderer->setRendered(false);

        // Trigger CLI renderer
        $env->setIsCli(true);
        $awareRenderer->render(new \Exception(''));

        $this->assertFalse($defaultRenderer->isRendered());
        $this->assertTrue($cliRenderer->isRendered());
        $this->assertFalse($ajaxRenderer->isRendered());

        $cliRenderer->setRendered(false);

        // // Trigger AJAX renderer
        $env->setIsCli(false);
        $env->setIsAjaxRequest(true);
        $awareRenderer->render(new \Exception(''));

        $this->assertFalse($defaultRenderer->isRendered());
        $this->assertFalse($cliRenderer->isRendered());
        $this->assertTrue($ajaxRenderer->isRendered());
    }
}
