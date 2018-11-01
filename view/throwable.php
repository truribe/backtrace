<?php
/**
 * @file Template for a full Throwable.
 * @author Travis Uribe <travis@tvanc.com>
 *
 * @var HtmlExceptionRenderer $this
 * This template is required from within an object context.
 *
 * @var Throwable             $throwable
 * The throwable object being rendered.
 *
 * @var string                $assetsDir
 * The path to the assets directory.
 */

use tvanc\backtrace\Backtrace;
use tvanc\backtrace\Render\HtmlExceptionRenderer;

$trace      = $throwable->getTrace();
$reflection = new \ReflectionClass($throwable);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $reflection->getShortName() ?>: <?= $throwable->getMessage() ?></title>
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

    <?= $this->renderStage([
        'file' => $throwable->getFile(),
        'line' => $throwable->getLine()
    ]); ?>

    <?php if ($trace) { ?>
        <section class="err-backtrace">
            <header class="backtrace__header">
                <h3 class="backtrace__legend flex-big">Backtrace</h3>
            </header>
            <ol class="backtrace__stages">
                <?php foreach ($trace as $stage) { ?>
                    <li class="backtrace__stage">
                        <?= $this->renderStage($stage); ?>
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

