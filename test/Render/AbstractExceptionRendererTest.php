<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Render\ExceptionRendererInterface;
use tvanc\backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * Tests any basic exception-renderer implementation. We care about the
 * same details being in the output no matter the format so really the same
 * tests can work for almost any renderer.
 *
 * @see ExceptionRendererInterface
 * @see HtmlExceptionRendererTest
 * @see CliExceptionRendererTest
 */
abstract class AbstractExceptionRendererTest extends TestCase
    implements ExceptionRendererTestInterface
{
    /**
     * Test the render output. How do you test render output? You check that
     * the things you care about are somewhere in the output.
     *
     * @throws \ReflectionException
     */
    public function testRender()
    {
        $testMessage = \uniqid('boogiewoogie-test-blarp');
        $exception   = new ExceptionWithUnlikelyStringForName(
            $testMessage
        );

        $renderer  = $this->getRenderer();
        $render    = $renderer->render($exception);
        $shortName = (new \ReflectionClass($exception))->getShortName();
        $trace     = $exception->getTrace();

        $this->assertContains(
            $shortName,
            $render,
            'Render contains (at least) the non-FQCN of the throwable'
        );

        $this->assertContains(
            $testMessage,
            $render,
            'Render contains (at least) the full exception message'
        );

        foreach ($trace as $stage) {
            $this->assertContains(
                $renderer->renderStage($stage),
                $render,
                'The full render contains each rendered stage'
            );
        }
    }


    /**
     * Test that the renderStage() method outputs all the right info.
     *
     * @see \debug_backtrace()
     * @see http://php.net/manual/en/function.debug-backtrace.php
     */
    public function testRenderStage()
    {
        $renderer = $this->getRenderer();

        foreach (\debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS) as $stage) {
            $render = $renderer->renderStage($stage);

            $this->assertContains(
                basename($stage['file']),
                $render,
                'Render contains at least the basename (path may be ellided)'
            );

            $this->assertContains(
                $stage['line'] . '',
                $render,
                'Render of each stage contains the line number'
            );
        }
    }
}
