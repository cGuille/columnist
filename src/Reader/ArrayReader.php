<?php

declare(strict_types=1);

namespace Columnist\Reader;

use ArrayIterator;

class ArrayReader extends IteratorReader
{
    public function __construct(array $data)
    {
        parent::__construct(new ArrayIterator($data));
    }
}
