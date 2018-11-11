<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Render\Utility;

use TVanC\Backtrace\Render\Utility\Exception\InvalidDirectorySeparatorException;

/**
 * A class for shortening paths for display.
 */
class PathShortener
{
    const DEFAULT_REPLACEMENT_TOKEN = '…';

    private const SLASHES = [
        '/',
        '\\'
    ];

    /** @var string */
    private $replacementToken;

    /**
     * @var string
     */
    private $directorySeparator;


    /**
     * PathShortener constructor.
     *
     * @param string $replacementToken
     * The string to use when replacing parts of a path to indicate that
     * ellision has occurred.
     *
     * @param string $directorySeparator
     * The string to force to be used as a directory separator. Defaults
     * to the system default.
     * Must be either a backslash "\" or forward slash "/".
     */
    public function __construct(
        string $replacementToken = self::DEFAULT_REPLACEMENT_TOKEN,
        string $directorySeparator = \DIRECTORY_SEPARATOR
    ) {
        $this->replacementToken   = $replacementToken;
        $this->directorySeparator = $directorySeparator;

        if (!in_array($directorySeparator, self::SLASHES)) {
            throw new InvalidDirectorySeparatorException(
                self::SLASHES,
                $directorySeparator
            );
        }
    }


    /**
     * Remove the given starting path from the given full path.
     *
     * @param string $path
     * The full path, from which to remove the given starting path.
     *
     * @param string $startingPath
     * The starting path to remove from the full path.
     *
     * @param bool   $useLeadingSlash
     * Whether to add a starting slash to the returned path after replacing the
     * starting path with a replacement token.
     *
     * @return string
     * The full path with the given starting path removed. Occurrences of
     * $startingPath present anywhere other than at the start of $path
     * will not be removed.
     */
    public function elideStartingPath(string $path, string $startingPath, $useLeadingSlash = true)
    {
        if (strpos($path, $startingPath) === 0) {
            $primaryResult = $this->replacementToken .
                $this->normalizeSlashes(
                    substr($path, strlen($startingPath))
                );

            if ($useLeadingSlash) {
                return $this->directorySeparator . $primaryResult;
            }

            return $primaryResult;
        }

        return $path;
    }


    /**
     * Force the given path to use the same kind of slash throughout.
     *
     * @param $path
     *
     * @return string
     */
    public function normalizeSlashes($path)
    {
        $wrongKind = $this->directorySeparator === '/' ? '\\' : '/';

        return str_replace($wrongKind, $this->directorySeparator, $path);
    }
}
