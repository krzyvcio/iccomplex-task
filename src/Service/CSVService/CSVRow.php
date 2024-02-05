<?php
declare(strict_types=1);

namespace App\Service\CSVService;

class CSVRow
{

    public function __construct(
        private string $zone,
        private float  $shippingCost
    )
    {
    }

    public static function create(string $zone, float $shippingCost): self
    {
        return new self($zone, $shippingCost);
    }

    public function getZone(): string
    {
        return $this->zone;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }


}