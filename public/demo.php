<?php
/**
 * @file Demonstrate simple error handler usage and utility.
 * @author Travis Uribe <travis@tvanc.com>
 */

use tvanc\backtrace\Error\Responder\HtmlErrorResponder;
use tvanc\backtrace\Error\Listener\ErrorListener;

require '../vendor/autoload.php';
require '../inc/example-include-1.php';
require '../inc/example-include-2.php';

$listener = new ErrorListener([
    // Use an error handler that generates HTML
    new HtmlErrorResponder()
]);
$listener->listenForExceptions();

foo();
