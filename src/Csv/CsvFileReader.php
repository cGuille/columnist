<?php

declare(strict_types=1);

namespace Columnist\Csv;

use Columnist\Reader\AbstractReader;
use InvalidArgumentException;
use LogicException;
use RuntimeException;

class CsvFileReader extends AbstractReader
{
    public Options $options;
    public bool $parseHeaders = true;
    public int $maxReadLength = 0;

    /**
     * @var resource
     */
    private $input;
    private bool $ownInput;

    private bool $headersRead = false;
    private ?array $headers = null;

    public static function fromPath(string $filePath): self
    {
        $input = \fopen($filePath, 'r');
        if (!$input) {
            throw new InvalidArgumentException("Could not open file '$filePath' for reading");
        }

        return new self($input, true);
    }

    public static function fromStdin(): self
    {
        return new self(STDIN);
    }

    public function __construct($csvReadableFile, bool $ownInput = false)
    {
        $this->input = $csvReadableFile;
        $this->ownInput = $ownInput;
        $this->options = new Options();
    }

    public function __destruct()
    {
        if ($this->ownInput) {
            \fclose($this->input);
        }
    }

    public function readHeaders(): ?array
    {
        if ($this->headersRead) {
            throw new LogicException('Headers already read');
        }

        $this->headersRead = true;

        if (!$this->parseHeaders) {
            return null;
        }

        $headers = $this->readCsvEntry();
        if ($headers === false) {
            return null;
        }

        $this->headers = $headers;

        return $this->headers;
    }

    public function readRow(): ?array
    {
        $row = $this->readCsvEntry();
        if (!$row) {
            return null;
        }

        if ($this->headers) {
            $this->checkRow($row);
            $row = \array_combine($this->headers, $row);
        }

        return $row;
    }

    private function readCsvEntry()
    {
        return \fgetcsv(
            $this->input,
            $this->maxReadLength,
            $this->options->delimiter,
            $this->options->enclosure,
            $this->options->escape
        );
    }

    private function checkRow(array $row): void
    {
        $headersCount = \count($this->headers);
        $rowValuesCount = \count($row);

        if ($headersCount === $rowValuesCount) {
            return;
        }

        function listToString(array $arr): string
        {
            return '[' . \implode(', ', \array_map(function ($val) {
                return \var_export($val, true);
            }, $arr)) . ']';
        }

        throw new RuntimeException(\sprintf(
            'CSV row %s has a different number of values (%s) than the headers %s (%s)',
            listToString($row),
            $rowValuesCount,
            listToString($this->headers),
            $headersCount
        ));
    }
}
