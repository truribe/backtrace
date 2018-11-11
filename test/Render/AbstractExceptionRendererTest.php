<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Test\Render;

use PHPUnit\Framework\TestCase;
use tvanc\backtrace\Render\AbstractExceptionRenderer;
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
    public static function setUpBeforeClass()
    {
        $path = implode(\DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'Fixture',
            'functions.php'
        ]);

        /** @noinspection PhpIncludeInspection */
        require_once realpath($path);
    }


    private function getException (string $message) {
        try {
            \tvanc\backtrace\Fixture\foo($message);
        }
        catch (ExceptionWithUnlikelyStringForName $ex) {
            return $ex;
        }

        throw new \Exception('Excepted exception not caught.');
    }

    /**
     * Test the static getErrorDisplayType() method
     *
     * @see ExceptionRendererInterface::getErrorDisplayType()
     * @see AbstractExceptionRenderer::getErrorDisplayType()
     */
    public function testGetErrorDisplayType()
    {
        /** @var ExceptionRendererInterface $class */
        $class        = get_class($this->getRenderer());
        $regException = new ExceptionWithUnlikelyStringForName('');
        $errException = new \ErrorException('', 0, \E_USER_ERROR);

        $regExceptionReflection = new \ReflectionClass($regException);
        $regExceptionShortName  = $regExceptionReflection->getShortName();

        $this->assertEquals(
            ExceptionWithUnlikelyStringForName::class,
            $class::getErrorDisplayType($regException, false),
            'Name is left "ugly"'
        );

        $this->assertEquals(
            $regExceptionShortName,
            $class::getErrorDisplayType($regException, true),
            'Name  is made "pretty" by reducing to short name'
        );

        $this->assertEquals(
            \ErrorException::class,
            $class::getErrorDisplayType($errException, false),
            'Even ErrorException is left "ugly" when specified'
        );

        $this->assertNotEquals(
            \ErrorException::class,
            $class::getErrorDisplayType($errException, true),
            'For `ErrorException`s, a friendly string is used instead'
        );
    }


    /**
     * Test the render output. How do you test output? You test that the
     * information you care about is in the output.
     *
     * @throws \ReflectionException
     */
    public function testRender()
    {
        $testMessage = \uniqid('boogiewoogie-test-blarp');
        $exception   = $this->getException($testMessage);

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
