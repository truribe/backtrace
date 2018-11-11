<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\Backtrace\Render;

use tvanc\Backtrace\Render\Utility\FilePreviewer;

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
    private $frameTemplate;

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
     * @param string $frameTemplate
     * @param int    $sourceRadius
     * @param int    $frameRadius
     */
    public function __construct(
        string $viewDir,
        string $assetsDir,
        string $traceTemplate,
        string $frameTemplate,
        int $sourceRadius = 5,
        int $frameRadius = 3
    ) {
        $this->templatePath = $viewDir;
        $this->assetsDir    = $assetsDir;

        $this->traceTemplate = $traceTemplate;
        $this->frameTemplate = $frameTemplate;
        $this->sourceRadius  = $sourceRadius;
        $this->frameRadius   = $frameRadius;
    }


    public function render(\Throwable $throwable): string
    {
        return $this->loadTemplate($this->traceTemplate, [
            'pretty_type' => self::getErrorDisplayType($throwable, true),
            'type'        => self::getErrorDisplayType($throwable, false),
            'trace'       => $throwable->getTrace(),
            'assets_dir'  => $this->assetsDir,
            'throwable'   => $throwable,
        ]);
    }


    public function renderSourcePreview(array $frame)
    {
        $this->previewRadius = $this->sourceRadius;

        return $this->renderFrame($frame);
    }


    public function renderFrame(array $frame): string
    {
        $previewer          = new FilePreviewer();
        $reportedFocalPoint = $frame['line'];
        $focalPoint         = $reportedFocalPoint - 1;
        $radius             = $this->previewRadius ?? $this->frameRadius;
        $start              = max($focalPoint - $radius, 0);
        $end                = $focalPoint + $radius;

        return $this->loadTemplate($this->frameTemplate, [
            'frame' => $frame,
            'lines' => $previewer->getText($frame['file'], $start, $end),
            'line'  => $reportedFocalPoint,
            'start' => $start,
        ]);
    }


    public function renderFramePreview(array $frame)
    {
        $this->previewRadius = $this->frameRadius;

        return $this->renderFrame($frame);
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
}
