<?php

declare(strict_types=1);

namespace Columnist\Processor;

use Columnist\Reader\BaseReaderTrait;

trait BaseProcessorTrait
{
    use BaseReaderTrait;

    public function readHeaders(): ?array
    {
        return $this->attachedReader->readHeaders();
    }

    public function readRow(): ?array
    {
        return $this->attachedReader->readRow();
    }
}
