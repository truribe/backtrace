<?php
/**
 * @file Template for individual frames of a backtrace.
 * @author Travis Van Couvering <travis@tvanc.com>
 *
 * @var int    $radius
 * The number of lines to show before and after the line indicated in $frame
 * INCLUDING that line. In other words, a value of 0 (zero) will result in no
 * lines being displayed. A value of 1 will show only the line indicated. A
 * value of 2 will show a total of three lines, the line before, THE line, and
 * the line after.
 *
 * @var int    $start
 * @var int    $line
 * @var string $lines
 *
 * @var array  $frame
 * An associative array with ALMOST any of the following potential elements:
 * - line
 * - file
 * - function
 * - class
 * - object
 * - type
 * - args
 * In my experience, `line` and `file` are GUARANTEED to be present after PHP 7.
 * Everything else is totally up in the air though!
 */
$humanStart = $start + 1;
?>
<?php if (isset($frame['file'])) { ?>
    <div class="err-info">
        <span class="err-file"><?= $frame['file'] ?></span><span
                class="err-file-line-joint">:</span><span
                class="err-line"><?= $frame['line'] ?></span>
    </div>
<?php } ?>
<div class="err-preview">
    <?php
    if (!isset($frame['file']) || !file_exists($frame['file'])) {
        ?>
        <div class="err-preview-line">
            <code class="err-preview-code">{closure}</code>
        </div>
        <?php
    } else {
        echo "<pre class='line-numbers language-php' data-line-offset='$start' data-line='$line' data-start='$humanStart'>";
        echo '<code class="err-preview-code">';
        echo htmlentities($lines);
        echo '</code></pre>';
    }
    ?>
</div>

