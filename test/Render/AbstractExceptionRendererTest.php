<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Render\ExceptionRendererInterface;
use tvanc\backtrace\Test\Render\Exception\ExceptionWithUnlikelyStringForName;

/**
 * Tests for any exception-renderer implementation. Not really so much the
 * EnvironmentAwareRendererer though.
 *
 * @see ExceptionRendererInterface
 */
abstract class AbstractExceptionRendererTest extends TestCase
    implements ExceptionRendererTestInterface
{
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
     * @see \debug_backtrace()
     * @see http://php.net/manual/en/function.debug-backtrace.php
     */
    public function testRenderStage()
    {
        $renderer  = $this->getRenderer();

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
