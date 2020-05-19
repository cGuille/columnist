<?php

declare(strict_types=1);

namespace Columnist\Reader;

use Columnist\Processor\ProcessorInterface;
use Columnist\Writer\WriterInterface;

trait BaseReaderTrait
{
    public function pipe(ProcessorInterface $processor): ProcessorInterface
    {
        $processor->attach($this);

        return $processor;
    }

    public function sinkTo(WriterInterface $writer): void
    {
        $writer->readFrom($this);
    }
}
