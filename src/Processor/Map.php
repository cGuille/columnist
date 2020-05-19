<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Map extends AbstractProcessor
{
    /**
     * @var callable|null
     */
    private $headersMapFunc;

    /**
     * @var callable|null
     */
    private $rowsMapFunc;

    public function mapHeaders(callable $func)
    {
        $this->headersMapFunc = $func;
    }

    public function mapRows(callable $func)
    {
        $this->rowsMapFunc = $func;
    }

    public function readHeaders(): ?array
    {
        return $this->map($this->headersMapFunc, parent::readHeaders());
    }

    public function readRow(): ?array
    {
        return $this->map($this->rowsMapFunc, parent::readRow());
    }

    private function map(?callable $mapper, ?array $data): ?array
    {
        if (!$mapper) {
            return $data;
        }

        if (!$data) {
            return $data;
        }

        return $mapper($data);
    }
}
