<?php
/**
 * TODO Add @file block for InvalidDirectorySeparatorException.php
 *
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Utility\Exception;

use Throwable;

/**
 * TODO Document InvalidDirectorySeparatorException
 */
class InvalidDirectorySeparatorException extends \InvalidArgumentException
{
    public function __construct(array $expected, string $received, int $code = 0, Throwable $previous = null)
    {
        $options = implode('", "', $expected);

        parent::__construct(
            "Expected one of \"$options\"; received \"$received\"",
            $code,
            $previous
        );
    }
}
