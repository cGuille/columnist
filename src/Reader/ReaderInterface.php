<?php

declare(strict_types=1);

namespace Columnist\Reader;

use Columnist\Processor\ProcessorInterface;
use Columnist\Writer\WriterInterface;

interface ReaderInterface
{
    /**
     * Read column headers from the source.
     *
     * Returns the headers as a list of strings.
     * If the source does not have column headers, returns null.
     *
     * @return string[]|null
     */
    public function readHeaders(): ?array;

    /**
     * Read a single row of data from the source.
     *
     * If the source has column headers, returns an associative array.
     * Otherwise, returns an indexed array.
     * When there are no more rows to read, returns null.
     */
    public function readRow(): ?array;

    /**
     * Chain a processor.
     */
    public function pipe(ProcessorInterface $reader): ProcessorInterface;

    /**
     * Configure where to write what we read.
     */
    public function sinkTo(WriterInterface $writerInterface): void;
}
