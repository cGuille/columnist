<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Counter extends AbstractProcessor
{
    private string $columnName;
    private int $n = 0;
    private bool $ended = false;

    public function __construct(string $columnName = 'count')
    {
        $this->columnName = $columnName;
    }

    public function readHeaders(): ?array
    {
        return [$this->columnName];
    }

    public function readRow(): ?array
    {
        if ($this->ended) {
            return null;
        }

        while (parent::readRow()) {
            ++$this->n;
        }

        $this->ended = true;

        return [$this->n];
    }
}
