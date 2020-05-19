<?php

declare(strict_types=1);

namespace Columnist\Writer;

use Columnist\Reader\ReaderInterface;

interface WriterInterface
{
    /**
     * Attach the given reader to this writer.
     */
    public function attach(ReaderInterface $reader): void;

    /**
     * Start processing data.
     */
    public function flow(): void;
}
