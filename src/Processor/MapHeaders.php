<?php

declare(strict_types=1);

namespace Columnist\Processor;

class MapHeaders extends AbstractProcessor
{
    private array $headersSubset;

    public function __construct(string ...$headersSubset)
    {
        $this->headersSubset = $headersSubset;
    }

    public function readHeaders(): ?array
    {
        $headers = parent::readHeaders();
        if (!$headers) {
            return null;
        }

        $mappedHeaders = [];

        foreach ($this->headersSubset as $requestedHeader) {
            if (\in_array($requestedHeader, $headers, true)) {
                $mappedHeaders[] = $requestedHeader;
            }
        }

        return $mappedHeaders;
    }

    public function readRow(): ?array
    {
        $row = parent::readRow();
        if (!$row) {
            return null;
        }

        $mappedRow = [];

        foreach ($this->headersSubset as $requestedHeader) {
            if (isset($row[$requestedHeader])) {
                $mappedRow[$requestedHeader] = $row[$requestedHeader];
            }
        }

        return $mappedRow;
    }
}
