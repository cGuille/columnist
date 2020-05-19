<?php

declare(strict_types=1);

namespace Columnist\Reader;

use Iterator;

class IteratorReader extends AbstractReader
{
    private Iterator $iterator;

    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function readHeaders(): ?array
    {
        $row = $this->iterator->current();
        $rowKeys = \array_keys($row);

        foreach ($rowKeys as $key) {
            if (\is_string($key)) {
                // Associative array → we assume keys are headers
                return $rowKeys;
            }
        }

        // No string key → probably an indexed array, so we assume there are no headers
        return null;
    }

    public function readRow(): ?array
    {
        if (!$this->iterator->valid()) {
            return null;
        }

        $row = $this->iterator->current();
        $this->iterator->next();

        return $row;
    }
}
