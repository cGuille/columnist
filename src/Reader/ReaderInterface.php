<?php

declare(strict_types=1);

namespace Columnist\Reader;

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
     * Chain another reader.
     */
    public function pipe(ReaderInterface $reader): ReaderInterface;

    /**
     * Required to be able to pipe
    */
    public function attach(ReaderInterface $reader): void;

    /**
     * Configure where to write what we read.
     */
    public function sinkTo(WriterInterface $writerInterface): void;
}
