<?php
/**
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

/**
 * Renders exceptions in glorious HTML format.
 */
class HtmlExceptionRenderer extends AbstractExceptionRenderer
{
    /**
     * @var string
     */
    private $templatePath;
    /**
     * @var string
     */
    private $traceTemplate;
    /**
     * @var string
     */
    private $stageTemplate;
    /**
     * @var string
     */
    private $assetsDir;


    /**
     * HtmlExceptionRenderer constructor.
     *
     * @param string $viewDir
     * @param string $assetsDir
     * @param string $traceTemplate
     * @param string $stageTemplate
     */
    public function __construct(
        string $viewDir,
        string $assetsDir,
        string $traceTemplate,
        string $stageTemplate
    ) {
        $this->templatePath = $viewDir;
        $this->assetsDir    = $assetsDir;

        $this->traceTemplate = $traceTemplate;
        $this->stageTemplate = $stageTemplate;
    }


    public function render(\Throwable $throwable): string
    {
        return $this->loadTemplate($this->traceTemplate, [
            'assetsDir' => $this->assetsDir,
            'throwable' => $throwable,
        ]);
    }


    /**
     * Load and return the result of an executed template file.
     *
     * @param string $templateFile
     * @param array  $vars
     *
     * @return string
     */
    private function loadTemplate(string $templateFile, array $vars): string
    {
        extract($vars);

        ob_start();
        /** @noinspection PhpIncludeInspection */
        require $this->templatePath . \DIRECTORY_SEPARATOR . $templateFile;

        return ob_get_clean();
    }


    public function renderStage(array $stage): string
    {
        return $this->loadTemplate($this->stageTemplate, [
            'stage'  => $stage,
            'radius' => 3,
        ]);
    }
}
