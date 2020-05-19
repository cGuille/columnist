<?php

declare(strict_types=1);

namespace Columnist\Writer;

use Columnist\Reader\ReaderInterface;

interface WriterInterface
{
    public function readFrom(ReaderInterface $reader): void;
}
