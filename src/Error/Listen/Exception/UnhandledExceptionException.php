<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Listen\Exception;

/**
 * Class UnhandledExceptionException
 *
 * @package tvanc\backtrace\Error\Listen
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
