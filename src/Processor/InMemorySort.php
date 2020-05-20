<?php

declare(strict_types=1);

namespace Columnist\Processor;

use InvalidArgumentException;

class InMemorySort extends AbstractProcessor
{
    private array $sortFields;
    private array $buffer;
    private bool $buffered = false;
    private int $nextRowIndex;

    public function __construct(string ...$sortFields)
    {
        if (count($sortFields) === 0) {
            throw new InvalidArgumentException('No sort field given');
        }

        $this->sortFields = $sortFields;
    }

    public function readRow(): ?array
    {
        if (!$this->buffered) {
            $this->bufferRows();
            $this->sortRows();
            $this->nextRowIndex = 0;
        }

        if (!isset($this->buffer[$this->nextRowIndex])) {
            $this->buffer = [];
            return null;
        }

        $row = $this->buffer[$this->nextRowIndex];
        ++$this->nextRowIndex;

        return $row;
    }

    private function bufferRows(): void
    {
        $this->buffer = [];

        while ($row = parent::readRow()) {
            $this->buffer[] = $row;
        }

        $this->buffered = true;
    }

    private function sortRows(): void
    {
        usort($this->buffer, function (array $left, array $right) {
            foreach ($this->sortFields as $sortField) {
                $result = $left[$sortField] <=> $right[$sortField];

                if ($result !== 0) {
                    return $result;
                }
            }

            return 0;
        });
    }
}
