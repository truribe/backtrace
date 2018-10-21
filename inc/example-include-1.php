<?php
/**
 * @file Provides code for a pretty example.
 * @author Travis Uribe <travis@tvanc.com>
 */

/**
 * Call a function that calls a function that throws an exception.
 */
function foo()
{
    bar();
}

/**
 * Call a function that throws an exception so we can get a backtrace.
 *
 * @throws \Exception
 */
function bar()
{
    baz();
}
