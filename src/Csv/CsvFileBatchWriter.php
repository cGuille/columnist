<?php

declare(strict_types=1);

namespace Columnist\Csv;

use Columnist\Reader\ReaderInterface;
use Columnist\Writer\WriterInterface;

class CsvFileBatchWriter implements WriterInterface
{
    public Options $options;
    public bool $ignoreHeaders = false;

    private ?array $headers;
    private ?CsvFileWriter $csvWriter;
    private string $pathTemplate;
    private int $batchSize;
    private int $batchNumber;

    public function __construct(int $batchSize, string $pathTemplate)
    {
        $this->options = new Options();
        $this->batchSize = $batchSize;
        $this-> pathTemplate = $pathTemplate;
    }

    public function readFrom(ReaderInterface $reader): void
    {
        $this->headers = $reader->readHeaders();

        $this->csvWriter = null;
        $this->batchNumber = 0;

        $currentBatchSize = 0;
        while ($row = $reader->readRow()) {
            if (!$this->csvWriter) {
                $this->startBatch();
            }

            $this->csvWriter->writeRow($row);
            ++$currentBatchSize;

            if ($currentBatchSize >= $this->batchSize) {
                $this->closeBatch();
                $currentBatchSize = 0;
            }
        }

        $this->closeBatch();
    }

    private function startBatch(): void
    {
        $this->csvWriter = CsvFileWriter::toPath($this->batchPath(), CsvFileWriter::MODE_CREATE);
        $this->csvWriter->options = $this->options;
        $this->csvWriter->ignoreHeaders = $this->ignoreHeaders;
        $this->csvWriter->writeHeaders($this->headers);
    }

    private function closeBatch(): void
    {
        $this->csvWriter = null;
        ++$this->batchNumber;
    }

    private function batchPath(): string
    {
        return \sprintf($this->pathTemplate, $this->batchNumber);
    }
}
