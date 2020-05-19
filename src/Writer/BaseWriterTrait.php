<?php

declare(strict_types=1);

namespace Columnist\Writer;

use Columnist\Reader\ReaderInterface;

trait BaseWriterTrait
{
    public function readFrom(ReaderInterface $reader): void
    {
        $headers = $reader->readHeaders();

        if ($headers) {
            $this->writeHeaders($headers);
        }

        while ($row = $reader->readRow()) {
            $this->writeRow($row);
        }
    }

    abstract protected function writeHeaders(array $headers): void;
    abstract protected function writeRow(array $row): void;
}
