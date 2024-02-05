<?php

namespace App\Entity;

use App\Repository\ShippingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ShippingRepository::class)]
class Shipping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 5)]
    #[Assert\NotNull(message: 'Postcode is required')]
    #[Assert\Length(min: 5, max: 5, exactMessage: 'Postcode must be 5 characters long')]
    private int $postcode;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Zone is required')]
    #[Assert\Length(min: 2, max: 2, exactMessage: 'Zone must be 2 characters long')]
    private string $zone;


    #[ORM\Column]
    private ?bool $longProduct;

    #[ORM\Column]
    #[Assert\Positive(message: 'Total amount must be a positive number')]
    private float $totalAmount = 0;

    #[ORM\Column]
    private float $shippingCost = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPostcode(): int
    {
        return $this->postcode;
    }

    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;

    }

    public function getZone(): int
    {
        return $this->zone;
    }

    public function setZone(int $zone): self
    {
        $this->zone = $zone;

        return $this;
    }


    public function getLongProduct(): ?bool
    {
        return $this->longProduct;
    }

    public function setLongProduct(?bool $longProduct): self
    {
        $this->longProduct = $longProduct;

        return $this;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;

    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $getShippingCost): self
    {
        $this->shippingCost = $getShippingCost;

        return $this;
    }


}
