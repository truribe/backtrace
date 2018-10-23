<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener\Exception;

/**
 * Class UnhandledExceptionException
 */
class UnhandledExceptionException extends \Exception
{
    /**
     * UnhandledExceptionException constructor.
     *
     * @param \Throwable $unhandledException
     */
    public function __construct(\Throwable $unhandledException)
    {
        parent::__construct(
            $unhandledException->getMessage(),
            $unhandledException->getCode()
        );
    }
}
