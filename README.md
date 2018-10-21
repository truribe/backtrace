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
use RentecTravis\backtrace\ErrorInterceptor;

ErrorInterceptor::handleAll();
```

### Handle errors and exceptions
**Think your code is clean?**
Halt execution and display an error message and backtrace for exceptions *and errors/warnings*.

```php
use RentecTravis\backtrace\ErrorInterceptor;

ErrorInterceptor::handleAll(true);
```

