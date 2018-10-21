# Backtrace
Get useful error messages with file previews and syntax highlighting.

In CLI mode or in the context of AJAX requests you'll get a simplified
plaintext backtrace like this:
```
EXCEPTION
-----------------------------------------------------------
An error occurred.

#0 --------------------------------------------------------
File:  /Users/tru/Documents/Projects/Rentec/backtrace/backtrace.php
Line:  20
Calls: blap
#1 --------------------------------------------------------
File:  /Users/tru/Documents/Projects/Rentec/backtrace/backtrace.php
Line:  23
Calls: bloop
-----------------------------------------------------------
```


## Installation
Install via `composer`:
```bash
composer require --dev tvanc/backtrace @dev
```

## Usage
### Handle exceptions only
Display an error message and backtrace for exceptions.
```php
use tvanc\backtrace\Error\Handle\HtmlErrorHandler;
use tvanc\backtrace\Error\Listen\ErrorListener;

// Create a listener with an HTML handler
$listener = new ErrorListener([new HtmlErrorHandler()]);

// Listen
$listener->listenForExceptions();
```

