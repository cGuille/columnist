<?php

declare(strict_types=1);

namespace Columnist\Reader;

use Columnist\Writer\WriterInterface;

trait BaseReaderTrait
{
    protected ReaderInterface $attachedReader;

    public function attach(ReaderInterface $reader): void
    {
        $this->attachedReader = $reader;
    }

    public function pipe(ReaderInterface $reader): ReaderInterface
    {
        $reader->attach($this);

        return $reader;
    }

    public function sinkTo(WriterInterface $writer): void
    {
        $writer->readFrom($this);
    }
}
