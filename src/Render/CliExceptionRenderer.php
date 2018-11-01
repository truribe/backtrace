<?php
/**
 * TODO Add @file block for CliBacktraceRenderer.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use tvanc\backtrace\Backtrace;
use tvanc\backtrace\Environment\CliInfoProvider;

/**
 * TODO Document class CliBacktraceRenderer
 */
class CliExceptionRenderer extends AbstractExceptionRenderer
{
    const DEFAULT_DIVIDER_LENGTH = 75;
    const OUTER_DIVIDER_CHAR = '=';
    const INNER_DIVIDER_CHAR = '-';

    /**
     * @var CliInfoProvider
     */
    private $cliInfo;


    public function __construct(CliInfoProvider $cliInfo)
    {
        $this->cliInfo = $cliInfo;
    }


    public function render(\Throwable $throwable): string
    {
        ob_start();
        $type = Backtrace::getErrorType($throwable);
        $outerLine = $this->makeDivider(self::OUTER_DIVIDER_CHAR);
        $innerLine = $this->makeDivider(
            self::INNER_DIVIDER_CHAR,
            min($this->cliInfo->getConsoleWidth(), strlen($type))
        );

        echo <<<MSG
$outerLine
$type
$innerLine
{$throwable->getMessage()}

MSG;
        foreach ($throwable->getTrace() as $index => $stage) {
            echo "\n" . $this->makeLine("#$index ") . "\n";
            echo $this->renderStage($stage);
        }
        echo "\n" . $outerLine . "\n\n";

        return ob_get_clean();
    }


    private function makeDivider($char = '-', $len = null)
    {
        return $this->makeLine('', $char, $len);
    }


    /**
     * Make a textual divider.
     *
     * @param string $label
     * The text to output at the start of the divider. Optional - defaults to an empty string.
     *
     * @param string $char
     * The character or characters to use for padding.
     *
     * @param int    $len
     * The maximum final length of the string. Leave blank to
     * default to 75, or the console width in CLI mode.
     *
     * @return string
     */
    private function makeLine(
        string $label = '',
        string $char = '-',
        int $len = null
    ) {
        if (is_null($len)) {
            $len = $this->cliInfo->getConsoleWidth();
        }

        return str_pad($label, $len, $char, STR_PAD_RIGHT);
    }


    public function renderStage(array $stage): string
    {
        if (isset($stage['file'])) {
            return <<<STAGE_RENDER
File:  {$stage['file']}
Line:  {$stage['line']}
Calls: {$stage['function']}
STAGE_RENDER;
        }

        $ignore = ['object', 'args'];
        $render = [];
        foreach ($stage as $key => $value) {
            if (in_array($key, $ignore)) {
                continue;
            }
            $render[] = str_pad(ucwords($key) . ':', 10, ' ') . $value;
        }

        return implode(\DIRECTORY_SEPARATOR, $render);
    }
}
