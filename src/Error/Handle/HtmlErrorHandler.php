<?php
/**
 * TODO Add @file documentation
 *
 * @author Travis Uribe <travis@tvanc.com>
 */

namespace tvanc\backtrace\Error\Handle;

use tvanc\backtrace\Backtrace;

/**
 * Class HtmlErrorHandler
 *
 * @package tvanc\backtrace\Error\Handle
 */
class HtmlErrorHandler implements ErrorHandlerInterface
{
    /**
     * @param \Throwable $throwable
     */
    public function catchThrowable(\Throwable $throwable)
    {
        $trace = $throwable->getTrace();

        // First element has same info as $ex->getFile() and $ex->getLine()
        $assetsDir = realpath('assets');
        $shortType = Backtrace::getErrorType($throwable);

        $first = [
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
        ];
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?= $shortType ?>: <?= $throwable->getMessage() ?></title>
            <link rel="stylesheet"
                  href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
                  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
                  crossorigin="anonymous">
            <style><?= file_get_contents($assetsDir . '/css/prism.css') ?></style>
            <style><?= file_get_contents($assetsDir . '/css/backtrace.css') ?></style>
        </head>
        <body>
        <main class="container">
            <header class="page-header error-header">
                <h1 class="error-type flex-big"><?= Backtrace::getErrorType($throwable, false); ?></h1>
            </header>

            <p class="err-msg lead"><?= $throwable->getMessage(); ?></p>

            <?= static::renderStage($first, 5, true); ?>

            <?php if ($trace) { ?>
                <section class="err-backtrace">
                    <header class="backtrace__header">
                        <h3 class="backtrace__legend flex-big">Backtrace</h3>
                    </header>
                    <ol class="backtrace__stages">
                        <?php foreach ($trace as $stage) { ?>
                            <li class="backtrace__stage">
                                <?= static::renderStage($stage); ?>
                            </li>
                        <?php } ?>
                    </ol>
                </section>
            <?php } ?>
        </main>

        <script src="https://code.jquery.com/jquery-2.2.3.min.js"
                integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="
                crossorigin="anonymous"></script>
        <script><?= file_get_contents($assetsDir . '/js/prism.js') ?></script>
        <script><?= file_get_contents($assetsDir . '/js/backtrace.js') ?></script>
        </body>
        </html>
        <?php
    }


    private static function renderStage(array $stage, $radius = 3, $showArgs = false)
    {
        ob_start();
        if (isset($stage['file'])) {
            ?>
            <div class="err-info">
                <span class="err-file"><?= $stage['file'] ?></span><span
                        class="err-file-line-joint">:</span><span
                        class="err-line"><?= $stage['line'] ?></span>
            </div>
            <?php
        }
        ?>
        <div class="err-preview">
            <?php
            if (!isset($stage['file']) || !file_exists($stage['file'])) {
                ?>
                <div class="err-preview-line">
                    <code class="err-preview-code">{closure}</code>
                </div>
                <?php
            } else {
                $lines = file($stage['file']);
                $lineNum = $stage['line'];
                $start = max($lineNum - $radius, 0);
                $end = min($lineNum + $radius, count($lines));
                $humanStart = $start + 1;

                echo "<pre class='line-numbers language-php' data-line-offset='$start' data-line='$lineNum' data-start='$humanStart'>";
                echo '<code class="err-preview-code">';

                foreach (range($start, $end) as $i) {
                    if (!isset($lines[$i])) {
                        break;
                    }

                    echo htmlentities($lines[$i]);
                }

                echo '</code></pre>';
            }

            if ($showArgs) {
                try {
                    // echo _backtrace_krumo($stage);
                } catch (\Throwable $ex) {
                    echo $ex->getMessage();
                }
            }
            ?>
        </div>
        <?php

        return ob_get_clean();
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
}
