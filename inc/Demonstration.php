<?php
/**
 * @author Travis Van Couvering <travis@tvanc.com>
 */

/**
 * Provides a class with some code to demonstrate this library's features.
 */
class Demonstration
{
    public function executePrimeDirective()
    {
        $this->performBehindTheScenesMagic();
    }

    protected function performBehindTheScenesMagic()
    {
        self::staticDemo();
    }

    private static function staticDemo()
    {
        throw new \Exception('How about a nice crispy backtrace?');
    }

    public function doNothing () {
        // That's too much pressure!
    }
}
