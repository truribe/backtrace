<?php
/**
 * TODO Add @file block for EnvironmentAwareRenderer.php
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use tvanc\backtrace\Environment\EnvironmentInterface;
use tvanc\backtrace\Render\Exception\NoRendererException;

/**
 * TODO Document class EnvironmentAwareRenderer
 */
class EnvironmentAwareRenderer extends AbstractExceptionRenderer
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var ExceptionRendererInterface
     */
    private $cliRenderer;

    /**
     * @var ExceptionRendererInterface
     */
    private $ajaxRenderer;

    /**
     * @var ExceptionRendererInterface
     */
    private $defaultRenderer;


    public function __construct(
        EnvironmentInterface $environment,
        ExceptionRendererInterface $cliRenderer,
        ExceptionRendererInterface $ajaxRenderer,
        ExceptionRendererInterface $defaultRenderer
    )
    {
        $this->environment = $environment;
        $this->cliRenderer = $cliRenderer;
        $this->ajaxRenderer = $ajaxRenderer;
        $this->defaultRenderer = $defaultRenderer;
    }


    /**
     * @param \Throwable $throwable
     *
     * @return string
     * @throws NoRendererException
     */
    public function render(\Throwable $throwable): string
    {
        return $this->selectRenderer($throwable)->render($throwable);
    }


    /**
     * @param array $stage
     *
     * @return string
     * @throws NoRendererException
     */
    public function renderStage(array $stage): string
    {
        return $this->selectRenderer()->render($stage);
    }


    /**
     * Select the appropriate renderer for the current environment.
     *
     * @param \Throwable $throwable
     *
     * @return ExceptionRendererInterface
     * @throws NoRendererException
     */
    private function selectRenderer (
        \Throwable $throwable = null
    ): ExceptionRendererInterface {
        if ($this->environment->isCli() && $this->cliRenderer) {
            return $this->cliRenderer;
        }

        if ($this->environment->isAjaxRequest() && $this->ajaxRenderer) {
            return $this->ajaxRenderer;
        }

        if ($this->defaultRenderer) {
            return $this->defaultRenderer;
        }

        if ($throwable) {
            throw new NoRendererException(
                "No renderer is configured",
                $throwable->getCode(),
                $throwable
            );
        }
        else {
            throw new NoRendererException("No renderer is configured");
        }
    }
}
