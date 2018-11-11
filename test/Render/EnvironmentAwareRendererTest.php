<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Error\Responder;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TVanC\Backtrace\Render\EnvironmentAwareRenderer;
use TVanC\Backtrace\Render\Exception\NoRendererException;
use TVanC\Backtrace\Test\Environment\TestEnvironment;
use TVanC\Backtrace\Test\Render\Mock\TestExceptionRenderer;

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
        $awareRenderer->renderFrame([]);

        $this->assertTrue($defaultRenderer->isRendered());
        $this->assertFalse($cliRenderer->isRendered());
        $this->assertFalse($ajaxRenderer->isRendered());

        $this->assertTrue($defaultRenderer->isFrameRendered());
        $this->assertFalse($cliRenderer->isFrameRendered());
        $this->assertFalse($ajaxRenderer->isFrameRendered());

        $defaultRenderer->setRendered(false, false);

        // Trigger CLI renderer
        $env->setIsCli(true);
        $awareRenderer->render(new \Exception(''));
        $awareRenderer->renderFrame([]);


        $this->assertFalse($defaultRenderer->isRendered());
        $this->assertTrue($cliRenderer->isRendered());
        $this->assertFalse($ajaxRenderer->isRendered());

        $cliRenderer->setRendered(false, false);

        // // Trigger AJAX renderer
        $env->setIsCli(false);
        $env->setIsAjaxRequest(true);
        $awareRenderer->render(new \Exception(''));
        $awareRenderer->renderFrame([]);

        $this->assertFalse($defaultRenderer->isRendered());
        $this->assertFalse($cliRenderer->isRendered());
        $this->assertTrue($ajaxRenderer->isRendered());
    }


    public function testRenderWithoutRendererThrowsNoRendererException()
    {
        $this->expectException(NoRendererException::class);
        $this->getRendererLessRenderer()->render(new \Exception());
    }


    public function testRenderFrameWithoutRendererThrowsNoRendererException()
    {
        $this->expectException(NoRendererException::class);
        $this->getRendererLessRenderer()->renderFrame([]);
    }


    /**
     * Get an EnvironmentAwareRenderer without any renderers.
     */
    private function getRendererLessRenderer()
    {
        $env = new TestEnvironment(false, false);

        return new EnvironmentAwareRenderer($env);
    }
}
