<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render;

use tvanc\backtrace\Render\Utility\FilePreviewer;

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
     * @var int
     */
    private $sourceRadius;

    /**
     * @var int
     */
    private $frameRadius;

    /**
     * @var int
     */
    private $previewRadius;


    /**
     * HtmlExceptionRenderer constructor.
     *
     * @param string $viewDir
     * @param string $assetsDir
     * @param string $traceTemplate
     * @param string $stageTemplate
     * @param int    $sourceRadius
     * @param int    $frameRadius
     */
    public function __construct(
        string $viewDir,
        string $assetsDir,
        string $traceTemplate,
        string $stageTemplate,
        int $sourceRadius = 5,
        int $frameRadius = 3
    ) {
        $this->templatePath = $viewDir;
        $this->assetsDir    = $assetsDir;

        $this->traceTemplate = $traceTemplate;
        $this->stageTemplate = $stageTemplate;
        $this->sourceRadius  = $sourceRadius;
        $this->frameRadius   = $frameRadius;
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


    public function renderSourcePreview(array $stage)
    {
        $this->previewRadius = $this->sourceRadius;

        return $this->renderStage($stage);
    }


    public function renderStage(array $stage): string
    {
        $previewer          = new FilePreviewer();
        $reportedFocalPoint = $stage['line'];
        $focalPoint         = $reportedFocalPoint - 1;
        $radius             = $this->previewRadius ?? $this->frameRadius;
        $start              = max($focalPoint - $radius, 0);
        $end                = $focalPoint + $radius;

        return $this->loadTemplate($this->stageTemplate, [
            'stage' => $stage,
            'lines' => $previewer->previewFile($stage['file'], $start, $end),
            'line'  => $reportedFocalPoint,
            'start' => $start,
        ]);
    }


    public function renderFramePreview(array $stage)
    {
        $this->previewRadius = $this->frameRadius;

        return $this->renderStage($stage);
    }
}
