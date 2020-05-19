<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Limit extends Range
{
    public function __construct(int $maxRows)
    {
        return parent::__construct(0, $maxRows);
    }
}
