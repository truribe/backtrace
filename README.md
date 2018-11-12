# Backtrace
[![Build Status](https://travis-ci.org/tvanc/backtrace.svg?branch=master)](https://travis-ci.org/tvanc/backtrace)

Get useful error messages with file previews and syntax highlighting.

## Installation
Install via `composer`:
```bash
composer require --dev tvanc/backtrace @dev
```

Or clone this repository:
```bash
git clone https://github.com/tvanc/backtrace.git
```

## Formats

### HTML
By default, Backtrace renders errors in HTML.
![alt](docs/assets/html-backtrace.png)

### Console
If Backtrace detects that you're using PHP from the command line it will
optimize the display of exceptions for console output.
![alt](docs/assets/cli-backtrace.png)

### Plaintext
If PHP is serving an XHR, Backtrace will format errors in plaintext.

```text
===========================================================================
Exception
---------
How about a nice, crispy backtrace?

#0 ------------------------------------------------------------------------
File:  /Users/tru/Documents/Projects/truribe/backtrace/inc/Demonstration.php
Line:  19
Calls: staticDemo
#1 ------------------------------------------------------------------------
File:  /Users/tru/Documents/Projects/truribe/backtrace/inc/Demonstration.php
Line:  13
Calls: performBehindTheScenesMagic
#2 ------------------------------------------------------------------------
File:  /Users/tru/Documents/Projects/truribe/backtrace/inc/example-include-2.php
Line:  15
Calls: executePrimeDirective
#3 ------------------------------------------------------------------------
File:  /Users/tru/Documents/Projects/truribe/backtrace/inc/example-include-1.php
Line:  12
Calls: bar
#4 ------------------------------------------------------------------------
File:  /Users/tru/Documents/Projects/truribe/backtrace/public/demo.php
Line:  15
Calls: foo
===========================================================================

```

## Usage

### Default usage
Display an error message and backtrace for exceptions, with the optimal
format automatically selected according to the environment in which the error
or exception is thrown.

```php
use TVanC\Backtrace\Backtrace;

// Register a listener that detects your environment type and automatically
// selects the appropriate format to use for rendering errors.
Backtrace::createListener()->listen();
```

### Custom usage
Configure your own listener, responder, and renderer.
```php
use tvanc/Backtrace as Backtrace;

$renderer  = new Backtrace\Render\PlaintextExceptionRenderer();
$responder = new Backtrace\Error\Responder\DebugResponder($renderer);
$listener  = new Backtrace\Error\Listener\ErrorListener([$responder], true); 
```

To create your own renderer, implement
`TVanC\Backtrace\Render\ExceptionRendererInterface` 
or extend `TVanC\Backtrace\Render\AbstractExceptionRenderer`.

Technically you don't even have to render exceptions if you don't want to.
Implement `TVanC\Backtrace\Error\Responder\ErrorResponderInterface` and add it 
to your listener.

## Coming Soon
- Arguments in the backtrace.
