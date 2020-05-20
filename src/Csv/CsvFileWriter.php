<?php

declare(strict_types=1);

namespace Columnist\Csv;

use Columnist\Writer\AbstractWriter;
use InvalidArgumentException;

class CsvFileWriter extends AbstractWriter
{
    public const MODE_APPEND = 'append';
    public const MODE_CREATE = 'create';
    public const MODE_ERASE = 'erase';

    private const MODES = [
        self::MODE_APPEND => 'a',
        self::MODE_CREATE => 'x',
        self::MODE_ERASE => 'w',
    ];

    public Options $options;
    public bool $ignoreHeaders = false;

    /**
     * @var resource
     */
    private $output;
    private bool $ownOutput;

    public static function toPath(string $filePath, string $mode = self::MODE_CREATE): self
    {
        $fileMode = self::fileMode($mode);
        $output = \fopen($filePath, $fileMode);
        if (!$output) {
            throw new InvalidArgumentException("Could not open file at '$filePath' with mode '$fileMode'");
        }

        return new self($output, true);
    }

    public static function toStdout(): self
    {
        return new self(STDOUT);
    }

    public function __construct($csvWritableFile, bool $ownOutput = false)
    {
        $this->output = $csvWritableFile;
        $this->ownOutput = $ownOutput;
        $this->options = new Options();
    }

    public function __destruct()
    {
        if ($this->ownOutput) {
            \fclose($this->output);
        }
    }

    public function writeHeaders(array $headers): void
    {
        if (!$this->ignoreHeaders) {
            $this->writeEntry($headers);
        }
    }

    public function writeRow(array $row): bool
    {
        return $this->writeEntry($row);
    }

    private function writeEntry(array $row): bool
    {
        return false !== @\fputcsv(
            $this->output,
            $row,
            $this->options->delimiter,
            $this->options->enclosure,
            $this->options->escape
        );
    }

    private static function fileMode(string $mode): string
    {
        if (!isset(self::MODES[$mode])) {
            throw new InvalidArgumentException("Invalid mode '$mode'");
        }

        return self::MODES[$mode];
    }
}
