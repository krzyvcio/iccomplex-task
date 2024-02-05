<?php
declare(strict_types=1);

namespace App\Service\CSVService;

use App\Data\ZonesShippingCostsData;
use Exception;
use Throwable;

class CSVService
{
    public const SEPARATOR = ',';

    public function __construct()
    {

    }

    public function validateFile($file): array
    {
        $errors = [];

        if ($file === null) {
            $errors[] = 'No file uploaded';
        }

        if ($file->getSize() > 1000000) {
            $errors[] = 'File is too large';
        }

        return $errors;
    }

    public function validateMimeType(string $mimeType): bool
    {
        if ($mimeType !== 'text/csv') {
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function readFile(string $fileName): ?ZonesShippingCostsData
    {

        try {
            $file = fopen('uploads/' . $fileName, 'r');

            $csv = ZonesShippingCostsData::create($fileName);

            while (($row = fgetcsv($file)) !== false) {
                $csv->addRow($row);
            }

            fclose($file);

            return $csv;
        } catch (Throwable  $e) {
            throw new Exception('Error reading file: ' . $e->getMessage());
        }
    }

}