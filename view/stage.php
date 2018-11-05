<?php
/**
 * @file Template for individual stages of a backtrace.
 * @author Travis Van Couvering <travis@tvanc.com>
 *
 * @var int $radius
 * The number of lines to show before and after the line indicated in $stage
 * INCLUDING that line. In other words, a value of 0 (zero) will result in no
 * lines being displayed. A value of 1 will show only the line indicated. A
 * value of 2 will show a total of three lines, the line before, THE line, and
 * the line after.
 *
 * @var array $stage
 * An associative array with ALMOST any of the following potential elements:
 * - line
 * - file
 * - function
 * - class
 * - object
 * - type
 * - args
 * In my experience, `line` and `file` are GUARANTEED to be present. Everything
 * else is totally up in the air though!
 */
?>
<?php if (isset($stage['file'])) { ?>
    <div class="err-info">
        <span class="err-file"><?= $stage['file'] ?></span><span
                class="err-file-line-joint">:</span><span
                class="err-line"><?= $stage['line'] ?></span>
    </div>
<?php } ?>
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
    ?>
</div>

