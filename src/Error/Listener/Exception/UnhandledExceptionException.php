<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listener\Exception;

/**
 * An exception for when a listener hears an error or exception, but isn't
 * equipped with an appropriate handler.
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
