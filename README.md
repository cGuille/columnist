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

## Concept

- Reader: a reader produces CSV contents. It is an instance of `Columnist\Reader\ReaderInterface`.
- Writer: a writer pulls CSV contents from a reader and does something with it. It is an instance of `Columnist\Writer\WriterInterface`.
- Processor: a processor is special kind of reader that can be chained to other readers. It consumes data from its attached reader and does something with it. It is an instance of `Columnist\Processor\ProcessorInterface`, that extends `ReaderInterface`.

## Basic usage

Here is what a basic piece of code can look like:

```php
<?php
$reader = CsvPipe\Reader\CsvFileReader::fromStdin();
$writer = CsvPipe\Writer\CsvFileWriter::toStdout();

$reader->options->delimiter = ';';
$writer->options->delimiter = ','; // this is actually redundant since it is the default

// This will convert the CSV content from the standard input from semicolon-delimited
// to comma delimited and output the result to the standard output.
$reader->sinkTo($writer);
```

Processors can be chained in between the reader and the writer:

```php
<?php
$reader = new Columnist\Reader\ArrayReader([
    [1, 2],
    [5, -7],
    [0, 8],
]);
$writer = Columnist\Csv\CsvFileWriter::toStdout();

$mapping = new Columnist\Processor\Map();

$mapping->mapRows(function (array $row) {
    // Compute the sum:
    $result = $row[0] + $row[1];

    // Assign the result to a new column:
    $row[2] = $result;

    // Return the $row containing the change:
    return $row;
});

$filter = new Columnist\Processor\Filter(function (array $row) {
    return $row[2] >= 0;
});

$reader
    ->pipe($mapping) // will store the sum of the first two columns in a new column
    ->pipe($filter) // will keep only the positive results
    ->sinkTo($writer) // output as CSV to the standard output
;
```

## TODO

- Testing.
- Documentation and examples.
