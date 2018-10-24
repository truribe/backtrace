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
    public function handleException(\Throwable $throwable)
    {
        if ($this->environment->isCli() && $this->cliHandler) {
            return $this->cliHandler->handleException($throwable);
        }

        if ($this->environment->isAjaxRequest() && $this->ajaxHandler) {
            return $this->ajaxHandler->handleException($throwable);
        }

        if ($this->defaultHandler) {
            return $this->defaultHandler->handleException($throwable);
        }

        return false;
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


    public function considerException(\Throwable $throwable): bool
    {
        return true;
    }
}
