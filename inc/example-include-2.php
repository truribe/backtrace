<?php
/**
 * @file Provide another file with plenty of code for a pretty example.
 * @author Travis Van Couvering <travis@tvanc.com>
 */
require 'Demonstration.php';


/**
 * Throw an example exception.
 */
function bar()
{
    $demo = new Demonstration();
    $demo->executePrimeDirective();
}

function filler_content_for_looks()
{
    echo 'I never get called but I look pretty';
}
