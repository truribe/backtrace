<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handler;

use tvanc\backtrace\Environment\EnvironmentInterface;

/**
 * The temptation to name this class EnvironmentallyAwareHandler was all
 * but overpowering.
 */
class EnvironmentAwareHandler implements ErrorHandlerInterface
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var ErrorHandlerInterface
     */
    private $cliHandler;

    /**
     * @var ErrorHandlerInterface
     */
    private $ajaxHandler;

    /**
     * @var ErrorHandlerInterface
     */
    private $defaultHandler;


    public function __construct(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }


    /**
     * @param \Throwable $throwable
     *
     * @return bool
     */
    public function catchThrowable(\Throwable $throwable)
    {
        if ($this->environment->isCli() && $this->cliHandler) {
            return $this->cliHandler->catchThrowable($throwable);
        }

        if ($this->environment->isAjaxRequest() && $this->ajaxHandler) {
            return $this->ajaxHandler->catchThrowable($throwable);
        }

        if ($this->defaultHandler) {
            return $this->defaultHandler->catchThrowable($throwable);
        }

        return false;
    }


    /**
     * @param $severity
     * @param $message
     * @param $fileName
     * @param $lineNumber
     *
     * @return mixed
     */
    public function handleError($severity, $message, $fileName, $lineNumber)
    {
        // TODO: Implement handleError() method.
    }


    /**
     * @param array $error
     *
     * @return mixed
     */
    public function handleFatalError(array $error)
    {
        // TODO: Implement handleFatalError() method.
    }


    /**
     * @param ErrorHandlerInterface $handler
     *
     * @return EnvironmentAwareHandler
     */
    public function setCliHandler(ErrorHandlerInterface $handler): self
    {
        $this->cliHandler = $handler;

        return $this;
    }


    /**
     * @param ErrorHandlerInterface $ajaxHandler
     *
     * @return EnvironmentAwareHandler
     */
    public function setAjaxHandler(ErrorHandlerInterface $ajaxHandler): self
    {
        $this->ajaxHandler = $ajaxHandler;

        return $this;
    }


    /**
     * @param ErrorHandlerInterface $defaultHandler
     *
     * @return EnvironmentAwareHandler
     */
    public function setDefaultHandler(ErrorHandlerInterface $defaultHandler): self
    {
        $this->defaultHandler = $defaultHandler;

        return $this;
    }
}
