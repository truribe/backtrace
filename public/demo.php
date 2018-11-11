<?php
/**
 * @file Demonstrate simple error responder usage and utility.
 * @author Travis Van Couvering <travis@tvanc.com>
 */

use tvanc\Backtrace\Backtrace;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../inc/example-include-1.php';
require __DIR__ . '/../inc/example-include-2.php';

Backtrace::createListener()->listen();

foo();
