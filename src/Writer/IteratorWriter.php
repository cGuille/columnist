<?php

declare(strict_types=1);

namespace Columnist\Writer;

use Columnist\Reader\ReaderInterface;
use Iterator;

class IteratorWriter implements WriterInterface, Iterator
{
    private ReaderInterface $reader;
    private ?array $headers;
    private int $currentRowIndex = 0;
    private ?array $currentRow;

    public function readFrom(ReaderInterface $reader): void
    {
        $this->reader = $reader;
        $this->headers = $reader->readHeaders();
        $this->readRow();
    }

    public function current(): ?array
    {
        return $this->currentRow;
    }

    public function key(): int
    {
        return $this->currentRowIndex;
    }

    public function next(): void
    {
        $this->readRow();
        ++$this->currentRowIndex;
    }

    public function rewind(): void
    {
    }

    public function valid(): bool
    {
        return $this->currentRow !== null;
    }

    private function readRow(): void
    {
        $row = $this->reader->readRow();

        if ($this->headers && $row) {
            \array_combine($this->headers, $row);
        }

        $this->currentRow = $row;
    }
}
