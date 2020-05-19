<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Filter extends AbstractProcessor
{
    /**
     * @var callable
     */
    private $filterFunc;

    public function __construct(callable $filterFunc)
    {
        $this->filterFunc = $filterFunc;
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
        return ($this->filterFunc)($row);
    }
}
