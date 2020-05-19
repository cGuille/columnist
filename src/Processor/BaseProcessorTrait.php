<?php

declare(strict_types=1);

namespace Columnist\Processor;

use Columnist\Reader\BaseReaderTrait;
use Columnist\Reader\ReaderInterface;

trait BaseProcessorTrait
{
    use BaseReaderTrait;

    protected ReaderInterface $attachedReader;

    public function attach(ReaderInterface $reader): void
    {
        $this->attachedReader = $reader;
    }

    public function readHeaders(): ?array
    {
        return $this->attachedReader->readHeaders();
    }

    public function readRow(): ?array
    {
        return $this->attachedReader->readRow();
    }
}
