<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

namespace TVanC\Backtrace\Test\Render\Utility;

use PHPUnit\Framework\TestCase;
use TVanC\Backtrace\Render\Utility\Exception\InvalidDirectorySeparatorException;
use TVanC\Backtrace\Render\Utility\PathShortener;

/**
 * A test case for the {@link PathShortener} class.
 *
 * @see PathShortener
 */
class PathShortenerTest extends TestCase
{

    public function testElideStartingPath()
    {
        $start              = '/harrison/ford/is/really/cool';
        $after              = '/but/wont/play/han/solo/again';
        $fullPath           = $start . $after;
        $pathWithStartLater = $after . $start;
        $replacementToken   = 'RAND_StRINg_bLeEP_BLoOp';
        $separator          = '/';
        $shortener          = new PathShortener($replacementToken, $separator);

        $expectedWithLeading = "/$replacementToken$after";
        $expectedNoLeading   = "$replacementToken$after";

        $shortenedWithLeadingSlash = $shortener->elideStartingPath(
            $fullPath,
            $start,
            true
        );

        $shortenedNoLeadingSlash = $shortener->elideStartingPath(
            $fullPath,
            $start,
            false
        );

        $this->assertEquals($expectedWithLeading, $shortenedWithLeadingSlash);
        $this->assertEquals($expectedNoLeading, $shortenedNoLeadingSlash);
        $this->assertEquals(
            $pathWithStartLater,
            $shortener->elideStartingPath($pathWithStartLater, $start, true),
            'Segment should only be elided if at the start'
        );
    }


    public function testNormalizeSlashes()
    {
        $rightSlash = '/';
        $wrongSlash = '\\';
        $segments   = [
            'padme',
            'and',
            'poe',
            'dameron',
            'hook',
            'up',
            'in',
            'Annihilation',
            'wtf'
        ];

        $wrongPath = $wrongSlash . \implode($wrongSlash, $segments);
        $rightPath = $rightSlash . \implode($rightSlash, $segments);
        $shortener = new PathShortener('whatever', $rightSlash);

        $this->assertEquals($rightPath, $shortener->normalizeSlashes($wrongPath));
    }


    public function testInvalidDirectorySeparatorException()
    {
        // These should not cause exceptions
        new PathShortener('whatev', '/');
        new PathShortener('whatev', '\\');

        $this->expectException(InvalidDirectorySeparatorException::class);

        // This should cause an exception
        new PathShortener('because', 'it\'s not a slash');
    }
}
