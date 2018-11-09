<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use tvanc\backtrace\Render\Utility\PathShortener;

/**
 * Renders an exception in a CLI-optimized format.
 */
class CliExceptionRenderer extends AbstractExceptionRenderer
{
    private $io;
    private $pathShortener;


    public function __construct()
    {
        $style = new SymfonyStyle(new StringInput(''), new ConsoleOutput());

        $this->io            = $style->getErrorStyle();
        $this->pathShortener = new PathShortener();
    }


    public function render(\Throwable $throwable): string
    {
        $trace = $throwable->getTrace();
        $io    = $this->io;

        ob_start();

        $io->error($throwable->getMessage());

        foreach ($trace as $index => $frame) {
            $io->text("#$index " . $this->summarizeFrame($frame));
        }

        foreach ($trace as $frame) {
            $this->renderStage($frame);
        }

        return \ob_get_clean();
    }


    private function summarizeFrame(array $frame): string
    {
        $file        = $this->pathShortener->elideStartingPath($frame['file'], getcwd());
        $line        = $frame['line'];
        $fileAndLine = $file . ':' . $line;
        $separator   = '-';

        if (isset($frame['function'])) {
            $function = $frame['function'] . '()';

            if (isset($frame['class'])) {
                $class = $frame['class'];
                $type  = $frame['type'];
                $icon  = '👁';
                $color = 'green';

                try {
                    $reflection = new \ReflectionClass($class);
                    $method     = $reflection->getMethod($frame['function']);
                    if ($method->isProtected()) {
                        $color = 'yellow';
                    } else {
                        if ($method->isPrivate()) {
                            $color = 'red';
                        }
                    }
                } catch (\ReflectionException $exception) {
                    $icon = '✘';
                }

                /** @lang text */
                return "<bg=$color>$icon</> <info>$class$type$function</info>" .
                    " $separator <info>$fileAndLine</info>";
            }

            return "<info>$function</info> $separator <info>$fileAndLine</info>";
        }

        return $fileAndLine;
    }


    public function renderStage(array $stage): string
    {
        return '';
    }
}
