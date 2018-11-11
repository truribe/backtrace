# Backtrace
Get useful error messages with file previews and syntax highlighting.
![alt](docs/assets/html-backtrace.png)

In CLI mode or in the context of AJAX requests you'll get a simplified
plaintext backtrace like this:
![alt](docs/assets/cli-backtrace.png)

## Installation
Install via `composer`:
```bash
composer require --dev tvanc/backtrace @dev
```

Or clone this repository:
```bash
git clone https://github.com/tvanc/backtrace.git
```

## Usage

### Default usage
Display an error message and backtrace for exceptions, with the optimal
format automatically selected according to the environment in which the error
or exception is thrown.

```php
use tvanc\backtrace\Backtrace;

// Register a listener that detects your environment type and automatically
// selects the appropriate format to use for rendering errors.
Backtrace::createListener()->listen();
```

### Custom usage
Configure your own listener, responder, and renderer.
```php
use tvanc/backtrace as Backtrace;

$renderer  = new Backtrace\Render\PlaintextExceptionRenderer();
$responder = new Backtrace\Error\Responder\DebugResponder($renderer);
$listener  = new Backtrace\Error\Listener\ErrorListener([$responder], true); 
```

To create your own renderer, implement
`tvanc\backtrace\Render\ExceptionRendererInterface` 
or extend `tvanc\backtrace\Render\AbstractExceptionRenderer`.

Technically you don't even have to render exceptions if you don't want to.
Implement `tvanc\backtrace\Error\Responder\ErrorResponderInterface` and add it 
to your listener.

## Coming Soon
- Arguments in the backtrace.
