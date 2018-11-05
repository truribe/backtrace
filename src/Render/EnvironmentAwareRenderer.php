<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use tvanc\backtrace\Environment\Environment;
use tvanc\backtrace\Environment\EnvironmentInterface;
use tvanc\backtrace\Render\Exception\NoRendererException;

/**
 * Renders exceptions in the optimum format for the current environment.
 */
class EnvironmentAwareRenderer extends AbstractExceptionRenderer
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var ExceptionRendererInterface
     * The renderer to use if the current environment is determined to be CLI.
     *
     * @see CliExceptionRenderer
     * @see Environment::isCli()
     */
    private $cliRenderer;

    /**
     * @var ExceptionRendererInterface
     * The renderer to use if the current environment is determined to be an
     * AJAX request.
     *
     * @see PlaintextExceptionRenderer
     * @see Environment::isAjaxRequest()
     */
    private $ajaxRenderer;

    /**
     * @var ExceptionRendererInterface
     * The renderer to use if the current environment is determined NOT to be
     * a CLI, or an AJAX request. OR no more-specific renderer was available.
     *
     * @see HtmlExceptionRenderer
     */
    private $defaultRenderer;


    public function __construct(
        EnvironmentInterface $environment,
        ExceptionRendererInterface $cliRenderer = null,
        ExceptionRendererInterface $ajaxRenderer = null,
        ExceptionRendererInterface $defaultRenderer = null
    ) {
        $this->environment     = $environment;
        $this->cliRenderer     = $cliRenderer;
        $this->ajaxRenderer    = $ajaxRenderer;
        $this->defaultRenderer = $defaultRenderer;
    }


    /**
     * @param ExceptionRendererInterface $cliRenderer
     *
     * @codeCoverageIgnore
     */
    public function setCliRenderer(ExceptionRendererInterface $cliRenderer): void
    {
        $this->cliRenderer = $cliRenderer;
    }


    /**
     * @param ExceptionRendererInterface $ajaxRenderer
     *
     * @codeCoverageIgnore
     */
    public function setAjaxRenderer(ExceptionRendererInterface $ajaxRenderer): void
    {
        $this->ajaxRenderer = $ajaxRenderer;
    }


    /**
     * @param ExceptionRendererInterface $defaultRenderer
     *
     * @codeCoverageIgnore
     */
    public function setDefaultRenderer(ExceptionRendererInterface $defaultRenderer): void
    {
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
     * Select the appropriate renderer for the current environment.
     *
     * @param \Throwable $throwable
     *
     * @return ExceptionRendererInterface
     * @throws NoRendererException
     */
    private function selectRenderer(
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
        } else {
            throw new NoRendererException("No renderer is configured");
        }
    }


    /**
     * @param array $stage
     *
     * @return string
     * @throws NoRendererException
     */
    public function renderStage(array $stage): string
    {
        return $this->selectRenderer()->renderStage($stage);
    }
}
