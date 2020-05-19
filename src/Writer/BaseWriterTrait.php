<?php

declare(strict_types=1);

namespace Columnist\Writer;

use Columnist\Reader\ReaderInterface;

trait BaseWriterTrait
{
    protected ReaderInterface $reader;

    public function attach(ReaderInterface $reader): void
    {
        $this->reader = $reader;
    }

    public function flow(): void
    {
        if (!$this->reader) {
            throw new \LogicException('No reader attached');
        }

        $headers = $this->reader->readHeaders();

        if ($headers) {
            $this->writeHeaders($headers);
        }

        while ($row = $this->reader->readRow()) {
            $this->writeRow($row);
        }
    }

    abstract protected function writeHeaders(array $headers): void;
    abstract protected function writeRow(array $row): void;
}
