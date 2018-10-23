<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

/**
 * Interface ErrorHandlerInterface
 */
interface ErrorResponderInterface
{
    /**
     * @param \Throwable $throwable
     *
     * @return mixed
     */
    public function catchThrowable(\Throwable $throwable);


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
