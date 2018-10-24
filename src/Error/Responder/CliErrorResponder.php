<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

use tvanc\backtrace\Backtrace;
use tvanc\backtrace\Environment\CliInfoProvider;

/**
 * Class CliErrorHandler
 *
 * TODO Integrate with symfony/console
 */
class CliErrorResponder implements ErrorResponderInterface
{
    const DEFAULT_DIVIDER_LENGTH = 75;

    /**
     * @var CliInfoProvider
     */
    private $cliInfo;


    public function __construct(CliInfoProvider $cliInfo)
    {
        $this->cliInfo = $cliInfo;
    }


    /**
     * @param \Throwable $throwable
     *
     * @return mixed
     */
    public function catchThrowable(\Throwable $throwable)
    {
        $type = strtoupper(Backtrace::getErrorType($throwable));
        $line = $this->makeDivider();
        echo <<<MSG

$type
$line
{$throwable->getMessage()}

MSG;

        foreach ($throwable->getTrace() as $index => $stage) {
            echo "\n" . $this->makeLine("#$index ") . "\n";
            if (!isset($stage['file'])) {
                $ignore = ['object', 'args'];
                $render = [];

                foreach ($stage as $key => $value) {
                    if (in_array($key, $ignore)) {
                        continue;
                    }
                    $render[] = str_pad(ucwords($key) . ':', 10, ' ') . $value;
                }

                echo implode("\n", $render);
            } else {
                echo <<<STAGE_RENDER
File:  {$stage['file']}
Line:  {$stage['line']}
Calls: {$stage['function']}
STAGE_RENDER;
            }
        }

        echo "\n" . $this->makeLine() . "\n\n";
    }


    /**
     * Make a textual divider.
     *
     * @param string   $label
     * The text to output at the start of the divider. Optional - defaults to an empty string.
     *
     * @param string   $char
     * The character or characters to use for padding.
     *
     * @param int|null $len
     * The maximum final length of the string. Leave blank to
     * default to 75, or the console width in CLI mode.
     *
     * @return string
     */
    private function makeLine($label = '', $char = '-', $len = null)
    {
        if (is_null($len)) {
            $len = $this->cliInfo->getConsoleWidth();
        }

        return str_pad($label, $len, $char, STR_PAD_RIGHT);
    }


    private function makeDivider($char = '-', $len = null)
    {
        return $this->makeLine('', $char, $len);
    }


    /**
     * @return CliInfoProvider
     */
    public function getCliInfo(): CliInfoProvider
    {
        return $this->cliInfo;
    }
}
