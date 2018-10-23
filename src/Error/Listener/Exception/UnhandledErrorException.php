<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener\Exception;

/**
 * Class UnhandledErrorException
 */
class UnhandledErrorException extends \ErrorException
{
    /**
     * UnhandledErrorException constructor.
     *
     * @param int    $severity
     * @param string $message
     * @param string $fileName
     * @param int    $lineNumber
     */
    public function __construct(
        int $severity,
        string $message,
        string $fileName,
        int $lineNumber
    ) {
        parent::__construct(
            "[Unhandled error] $message",
            0,
            $severity,
            $fileName,
            $lineNumber
        );
    }
}
