# Columnist

Convenient PHP utility to process column-based data.

I have found myself writing the same thing multiple times, that is: PHP code
to read CSV from stdin, process it, and write CSV to stdout.

This package provides convenient and simple tools to write ad-hoc scripts
transforming column-base data, such as big CSV files.

## Install

This package is not available on packagist as of today. You can require it with
composer using the repositories option:

```js
    // […]
    "require": {
        "cguille/columnist": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:cGuille/columnist.git"
        }
    ]
    // […]
```

Then you can start using this package's classes with the composer autoloader:
```php
require_once 'vendor/autoload.php';
```
## TODO

- Testing.
- Documentation: at least quick start and examples.
