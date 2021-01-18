<?php

namespace App\Services\Reports;

/**
 * Interface ReportGeneratorInterface
 */
interface ReportGeneratorInterface
{
    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return string
     */
    public function getFilePath(): string;
}
