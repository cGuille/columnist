<?php

declare(strict_types=1);

namespace Columnist\Reader;

use Columnist\Writer\WriterInterface;

trait BaseReaderTrait
{
    public function pipe(WriterInterface $writer): WriterInterface
    {
        $writer->attach($this);
        return $writer;
    }
}
