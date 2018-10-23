<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Responder;

use tvanc\backtrace\Environment\EnvironmentInterface;

/**
 * The temptation to name this class EnvironmentallyAwareHandler was all
 * but overpowering.
 */
class EnvironmentAwareResponder implements ErrorResponderInterface
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var ErrorResponderInterface
     */
    private $cliHandler;

    /**
     * @var ErrorResponderInterface
     */
    private $ajaxHandler;

    /**
     * @var ErrorResponderInterface
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
     * @param ErrorResponderInterface $handler
     *
     * @return EnvironmentAwareResponder
     */
    public function setCliHandler(ErrorResponderInterface $handler): self
    {
        $this->cliHandler = $handler;

        return $this;
    }


    /**
     * @param ErrorResponderInterface $ajaxHandler
     *
     * @return EnvironmentAwareResponder
     */
    public function setAjaxHandler(ErrorResponderInterface $ajaxHandler): self
    {
        $this->ajaxHandler = $ajaxHandler;

        return $this;
    }


    /**
     * @param ErrorResponderInterface $defaultHandler
     *
     * @return EnvironmentAwareResponder
     */
    public function setDefaultHandler(ErrorResponderInterface $defaultHandler): self
    {
        $this->defaultHandler = $defaultHandler;

        return $this;
    }
}
