<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Render\Utility\Exception;

use Throwable;

/**
 * Describes an error where one of a limited set of directory separators is
 * expected but the one received is not among that set.
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
