<?php
/**
 * @file Template for a full Throwable.
 * @author Travis Van Couvering <travis@tvanc.com>
 *
 * @var HtmlExceptionRenderer $this
 * This template is required from within an object context.
 *
 * @var Throwable             $throwable
 * The throwable object being rendered.
 *
 * @var string                $assets_dir
 * The path to the assets directory.
 *
 * @var string                $pretty_type
 * The 'prettified' name of the exception. May be the non-FQCN, or a "human"
 * description of an error, like "User error" instead of ErrorException.
 *
 * @var string                $type
 * The plain-ol' class name of the exception. May or may not be the
 * fully qualified class name.
 *
 * @var array[]               $trace
 * The backtrace for the throwable being rendered.
 */

use TVanC\Backtrace\Render\HtmlExceptionRenderer;

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $pretty_type ?>: <?= $throwable->getMessage() ?></title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <style><?= file_get_contents($assets_dir . '/css/prism.css') ?></style>
    <style><?= file_get_contents($assets_dir . '/css/backtrace.css') ?></style>
</head>
<body>
<main class="container">
    <header class="page-header error-header">
        <h1 class="error-type flex-big"><?= $type ?></h1>
    </header>

    <p class="err-msg lead"><?= $throwable->getMessage(); ?></p>

    <?php
    // Big preview for the source
    echo $this->renderSourcePreview([
        'file' => $throwable->getFile(),
        'line' => $throwable->getLine()
    ]);

    if ($trace) {
        ?>
        <section class="err-backtrace">
            <header class="backtrace__header">
                <h3 class="backtrace__legend flex-big">Backtrace</h3>
            </header>
            <ol class="backtrace__frames">
                <?php foreach ($trace as $frame) { ?>
                    <li class="backtrace__frame">
                        <?= $this->renderFramePreview($frame); ?>
                    </li>
                <?php } ?>
            </ol>
        </section>
        <?php
    }
    ?>
</main>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="
        crossorigin="anonymous"></script>
<script><?= file_get_contents($assets_dir . '/js/prism.js') ?></script>
<script><?= file_get_contents($assets_dir . '/js/backtrace.js') ?></script>
</body>
</html>

