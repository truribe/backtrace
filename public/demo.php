<?php
/**
 * @file Demonstrate simple error handler usage and utility.
 * @author Travis Uribe <travis@tvanc.com>
 */

use tvanc\backtrace\Backtrace;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../inc/example-include-1.php';
require __DIR__ . '/../inc/example-include-2.php';

Backtrace::createListener()->listen();

foo();
