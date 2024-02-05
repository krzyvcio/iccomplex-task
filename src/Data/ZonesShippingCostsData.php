<?php
declare(strict_types=1);

namespace App\Data;

use App\Service\CSVService\CSVRow;
use OutOfRangeException;

class ZonesShippingCostsData
{
    const ZONE_COL_ORDER_NUMBER = 0;
    const SHIPPING_COST_COL_ORDER_NUMBER = 1;

    private string $fileName;
    /** @var CSVRow[] */
    private array $data = [];
    private int $rowCount = 0;

    public function __construct(string $fileName, array $data = [])
    {
        $this->fileName = $fileName;
        $this->setData($data);
    }

    private function setData(array $data): void
    {
        foreach ($data as $row) {
            $this->addRow($row);
        }
    }

    public function addRow(array $row): self
    {
        $this->data[] = CSVRow::create(
            zone: $row[self::ZONE_COL_ORDER_NUMBER],
            shippingCost: (float)$row[self::SHIPPING_COST_COL_ORDER_NUMBER]
        );
        $this->rowCount++;
        return $this;
    }

    public static function create(string $fileName): self
    {
        return new self($fileName);
    }

    public function getRow(int $index): CSVRow
    {
        if (!isset($this->data[$index])) {
            throw new OutOfRangeException("Row {$index} does not exist.");
        }
        return $this->data[$index];
    }

    public function getRows(): array
    {
        return $this->data;
    }

    public function getNumberOfRows(): int
    {
        return $this->rowCount;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
