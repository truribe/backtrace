<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

/**
 * Interface ErrorHandlerInterface
 *
 * @package tvanc\backtrace\Handler
 */
interface ErrorHandlerInterface
{
    /**
     * @param \Throwable $exception
     *
     * @return mixed
     */
    public function catchThrowable(\Throwable $exception);


    /**
     * @param $severity
     * @param $message
     * @param $fileName
     * @param $lineNumber
     *
     * @return mixed
     */
    public function handleError($severity, $message, $fileName, $lineNumber);


    /**
     * @param array $error
     *
     * @return mixed
     */
    public function handleFatalError(array $error);
}
