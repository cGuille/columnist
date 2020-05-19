<?php

declare(strict_types=1);

namespace Columnist\Processor;

class Pager extends Range
{
    public function __construct(int $page, int $rowsPerPage)
    {
        $lowerBound = ($page - 1) * $rowsPerPage;
        $upperBound = $lowerBound + $rowsPerPage;

        return parent::__construct($lowerBound, $upperBound);
    }
}
