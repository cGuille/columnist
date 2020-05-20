<?php

declare(strict_types=1);

namespace Columnist\Processor;

use InvalidArgumentException;

class Dedup extends AbstractProcessor
{
    private array $dedupFields;
    private ?array $lastDedupValues = null;

    public function __construct(string ...$dedupFields)
    {
        if (count($dedupFields) === 0) {
            throw new InvalidArgumentException('No field to deduplicate on');
        }

        $this->dedupFields = \array_flip($dedupFields); // flipping for array_intersect_key()
    }

    public function readRow(): ?array
    {
        while ($row = parent::readRow()) {
            if ($this->accepts($row)) {
                break;
            }
        }

        return $row;
    }

    private function accepts(array $row): bool
    {
        $dedupValues = \array_intersect_key($row, $this->dedupFields);

        if ($this->lastDedupValues !== $dedupValues) {
            $this->lastDedupValues = $dedupValues;
            return true;
        }

        return false;
    }
}
