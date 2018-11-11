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
    public function getText(string $path, int $startLine, int $endLine): string
    {
        return $this->readFromFile($path, $startLine, $endLine, false);
    }


    public function getLines(string $path, int $startLine, int $endLine): array
    {
        return $this->readFromFile($path, $startLine, $endLine, true);
    }


    /**
     * @param string $path
     * The path to the file to preview.
     *
     * @param int    $startLine
     * The first line
     *
     * @param int    $endLine
     *
     * @param bool   $asArray
     *
     * @return string|string[]
     */
    private function readFromFile(
        string $path,
        int $startLine,
        int $endLine,
        bool $asArray
    ) {
        $file = new \SplFileObject($path, 'r');
        $file->seek($startLine);
        $lines = '';

        if ($asArray) {
            $lines = [];
        }

        do {
            $line = $file->current();

            if ($asArray) {
                $lines[$file->key()] = str_replace(["\r", "\n"], '', $line);
            } else {
                $lines .= $line;
            }

            $file->next();
        } while ($file->key() <= $endLine && $file->valid());

        return $lines;
    }
}
