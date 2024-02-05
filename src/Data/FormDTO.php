<?php

namespace App\Data;


class FormDTO
{

    private ?float $shippingCost = null;

    public function __construct(
        public ?int   $postCode,
        public ?float $totalAmount,
        public ?bool  $longProduct
    )
    {
    }

    public function getPostCode(): int
    {
        return $this->postCode;
    }

    public function setZone(): ?string
    {
        return $this->getZone();
    }

    public function getZone(): ?string
    {
        return $this->postCode ?
            (substr($this->postCode, 0, 2))
            : null;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function getLongProduct(): ?bool
    {
        return $this->longProduct;
    }

    public function setPostCode(?int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function setTotalAmount(?float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function setLongProduct(?bool $longProduct): self
    {
        $this->longProduct = $longProduct;
        return $this;
    }


    public function getShippingCost(): ?float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost): self
    {
        $this->shippingCost = $shippingCost;
        return $this;
    }


}
