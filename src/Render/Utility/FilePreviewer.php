<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Utility;

/**
 * A class for opening and extracting excerpts from files.
 */
class FilePreviewer
{
    /**
     * Gets a preview of the file at the given path, as a string.
     *
     * @param string $path
     * @param int    $startLine
     * @param int    $endLine
     *
     * @return string
     * The text of the file at the given path between the given lines.
     */
    public function getText(string $path, int $startLine, int $endLine): string
    {
        return $this->readFromFile($path, $startLine, $endLine, false);
    }


    /**
     * Gets the preview of the file at the given path, as an array keyed by
     * line number. Each line has end-of-line characters removed.
     *
     * @param string $path
     * @param int    $startLine
     * @param int    $endLine
     *
     * @return array
     * An array of the lines between the given start and end lines of the file
     * at the given path, with the end-of-line characters removed.
     */
    public function getLines(string $path, int $startLine, int $endLine): array
    {
        return $this->readFromFile($path, $startLine, $endLine, true);
    }


    /**
     * Retrieves the lines from the given file, between the given start and end
     * lines, inclusive.
     *
     * @param string $path
     * The path to the file to preview.
     *
     * @param int    $startLine
     * The first line of the file to read from.
     *
     * @param int    $endLine
     * The last line of the file to read from.
     *
     * @param bool   $asArray
     * Whether to return the excerpt as an array. True to return as array,
     * false to return as a string.
     *
     * @return string|string[]
     * Either a string containing the exact text from the file at the given path
     * and between the given lines, or an array of the lines comprising the same
     * text, and with end-of-line characters removed.
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
