<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Terminal;
use tvanc\backtrace\Render\Utility\ConsoleFormatter;
use tvanc\backtrace\Render\Utility\FilePreviewer;
use tvanc\backtrace\Render\Utility\PathShortener;

/**
 * Renders an exception in a CLI-optimized format.
 */
class CliExceptionRenderer extends AbstractExceptionRenderer
{
    /**
     * @var bool
     * Whether dependencies have been initialized.
     */
    private $initialized = false;

    /** @var PathShortener */
    private $pathShortener;

    /** @var FilePreviewer */
    private $previewer;

    /** @var StreamOutput */
    private $frameOutput;

    /** @var StreamOutput */
    private $mainOutput;


    public function render(\Throwable $throwable): string
    {
        $this->init();

        $trace = $throwable->getTrace();
        $io    = $this->getNewStyle($this->mainOutput);

        $io->block(
            $throwable->getMessage(),
            static::getErrorDisplayType($throwable, true),
            'fg=white;bg=red',
            ' ',
            true
        );

        array_unshift($trace, [
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ]);

        foreach ($trace as $index => $frame) {
            $io->text("#$index " . $this->summarizeFrame($frame));
        }

        $io->newLine();

        foreach ($trace as $frame) {
            $io->write($this->renderStage($frame));
            $io->newLine();
        }

        return $this->getDisplay($io);
    }


    public function renderStage(array $stage): string
    {
        $this->init();

        $radius     = 3;
        $focalPoint = $stage['line'] - 1;
        $start      = max($focalPoint - $radius, 0);
        $end        = $focalPoint + $radius;
        $numLength  = strlen((string)$end);
        $lines      = $this->previewer->getLines($stage['file'], $start, $end);

        $io = $this->getNewStyle($this->frameOutput);

        $io->text($this->summarizeFrame($stage));

        foreach ($lines as $lineNumber => $line) {
            $displayNumber = str_pad($lineNumber + 1, $numLength, ' ', \STR_PAD_LEFT);
            $displayText   = "$displayNumber | $line";

            if ($lineNumber === $focalPoint) {
                $width       = (new Terminal())->getWidth() - 9;
                $displayText = str_pad($displayText, $width, ' ', \STR_PAD_RIGHT);

                $io->text("<error>$displayText</error>");
            } else {
                $io->text("$displayText");
            }
        }

        return $this->getDisplay($io);
    }


    /**
     * Gets the output so far.
     *
     * @param SymfonyStyle $style
     *
     * @return string The display
     */
    private function getDisplay(SymfonyStyle $style)
    {
        $reflectedSymfonyStyle   = new \ReflectionObject($style);
        $reflectedParent         = $reflectedSymfonyStyle->getParentClass();
        $reflectedOutputProperty = $reflectedParent->getProperty('output');

        $reflectedOutputProperty->setAccessible(true);

        $output = $reflectedOutputProperty->getValue($style);
        $stream = $output->getStream();

        rewind($stream);
        $display = stream_get_contents($stream);
        ftruncate($stream, 0);

        return $display;
    }


    /**
     * Initialize dependencies.
     *
     * Sure I could inject these dependencies, but for requests where no
     * exception occurs does it make sense to create these objects if they'll
     * never actually be used?
     *
     * I could inject the names of the classes in and use the supplied names
     * to lazily create the dependencies. I could even use is_subclass_of()
     * and class_implements() to enforce type safety.... It's worth further
     * consideration.
     */
    private function init()
    {
        if (!$this->initialized) {
            $this->pathShortener = new PathShortener();
            $this->previewer     = new FilePreviewer();

            $this->mainOutput = new StreamOutput(
                fopen('php://memory', 'w', false),
                ConsoleOutput::VERBOSITY_NORMAL,
                true,
                new ConsoleFormatter(true)
            );

            $this->frameOutput = new StreamOutput(
                fopen('php://memory', 'w', false),
                ConsoleOutput::VERBOSITY_NORMAL,
                true,
                new ConsoleFormatter(true)
            );
        }

        $this->initialized = true;
    }


    private function getNewStyle(StreamOutput $output)
    {
        $style = new SymfonyStyle(new StringInput(''), $output);

        return $style->getErrorStyle();
    }


    private function summarizeFrame(array $frame): string
    {
        $file        = $this->pathShortener->elideStartingPath($frame['file'], getcwd());
        $line        = $frame['line'];
        $fileAndLine = "<file>$file</file><joiner>:</joiner><line>$line</line>";
        $separator   = '-';

        if (isset($frame['function'])) {
            $function = "<function>{$frame['function']}()</function>";

            if (isset($frame['class'])) {
                $class         = $frame['class'];
                $type          = $frame['type'];
                $icon          = '👁';
                $visibilityTag = 'public';

                try {
                    $reflection = new \ReflectionClass($class);
                    $method     = $reflection->getMethod($frame['function']);
                    if ($method->isProtected()) {
                        $visibilityTag = 'protected';
                    } else {
                        if ($method->isPrivate()) {
                            $visibilityTag = 'private';
                        }
                    }
                    // @codeCoverageIgnoreStart
                } catch (\ReflectionException $exception) {
                    $icon          = '✘';
                    $visibilityTag = 'indeterminate';
                }
                // @codeCoverageIgnoreEnd

                $visibilityIndicator = "<$visibilityTag>$icon</$visibilityTag>";
                $methodInfo          = "<class>$class</class>"
                    . "<type>$type</type>"
                    . "$function";

                /** @lang text */
                return "$visibilityIndicator $methodInfo $separator" .
                    " $fileAndLine";
            }

            return "$function $separator $fileAndLine";
        }

        return $fileAndLine;
    }
}
