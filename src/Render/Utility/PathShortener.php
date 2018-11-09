<?php
/**
 * TODO Add @file block for PathShortener.php * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace tvanc\backtrace\Render\Utility;

use tvanc\backtrace\Render\Utility\Exception\InvalidDirectorySeparatorException;

/**
 * TODO Document PathShortener
 */
class PathShortener
{
    const DEFAULT_REPLACEMENT_TOKEN = '…';

    private const SLASHES = [
        '/',
        '\\'
    ];

    private $replacementToken;
    /**
     * @var string
     */
    private $directorySeparator;


    /**
     * PathShortener constructor.
     *
     * @param string $replacementToken
     * @param string $directorySeparator
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


    public function elideStartingPath($path, $startingPath, $useLeadingSlash = true)
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


    public function normalizeSlashes($path)
    {
        $wrongKind = $this->directorySeparator === '/' ? '\\' : '/';

        return str_replace($wrongKind, $this->directorySeparator, $path);
    }
}
