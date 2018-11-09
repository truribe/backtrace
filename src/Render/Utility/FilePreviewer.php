<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Utility;

/**
 * TODO Document FilePreviewer
 */
class FilePreviewer
{
    /**
     * @param string $path
     * The path to the file to preview.
     *
     * @param int    $startLine
     * The first line
     *
     * @param int    $endLine
     *
     * @return string
     */
    public function previewFile(
        string $path,
        int $startLine,
        int $endLine
    ): string {
        $lines = '';
        $file  = new \SplFileObject($path);

        $file->seek($startLine);

        do {
            $lines .= $file->current();
            $file->next();
        } while ($file->key() <= $endLine && $file->valid());

        // Destroy reference. Someone on the internet said you should
        $file = null;

        return $lines;
    }
}
