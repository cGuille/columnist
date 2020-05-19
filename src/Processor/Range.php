<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Range extends AbstractProcessor
{
    private int $lowerBound;
    private ?int $upperBound;
    private int $n = 0;

    public function __construct(int $lowerBound, ?int $upperBound)
    {
        $this->lowerBound = $lowerBound;
        $this->upperBound = $upperBound;
    }

    public function readRow(): ?array
    {
        // Consume rows until we reach the lower bound
        while ($this->n < $this->lowerBound) {
            parent::readRow();
            ++$this->n;
        }

        if ($this->upperBound === null || $this->n < $this->upperBound) {
            ++$this->n;
            return parent::readRow();
        }

        return null;
    }
}
