<?php

namespace App\Service\ShippingService;

use App\Data\FormDTO;
use App\Entity\Shipping;
use App\Repository\ShippingRepository;
use Exception;
use Throwable;

class ShippingService
{

    private const DISCOUNT_AMOUNT = 12500;
    private const DISCOUNT_PERCENTAGE = 0.05;
    private const EXTRA_SHIPPING_COST = 1995;

    public function __construct(
        private readonly ShippingRepository $shippingRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function calculateAndSave(FormDTO $data): void
    {
        try {
            $totalAmount = $this->calculateDiscount($data);
            $shippingCost = $this->calculateShippingCost($data);

            $shipping = (new Shipping())
                ->setPostcode($data->getPostCode())
                ->setShippingCost($data->getShippingCost())
                ->setLongProduct($data->getLongProduct())
                ->setZone($data->getZone())
                ->setTotalAmount($totalAmount)
                ->setShippingCost($shippingCost);

            $this->shippingRepository->save($shipping);
        } catch (Throwable $e) {
            throw new Exception('Error while saving shipping data: ' . $e->getMessage());
        }

    }


    private function calculateDiscount(FormDTO $data): float
    {
        if ($data->getTotalAmount() > self::DISCOUNT_AMOUNT) {
            return $data->getTotalAmount() - ($data->getTotalAmount() * self::DISCOUNT_PERCENTAGE);
        }
        return $data->getTotalAmount();
    }


    /**
     * @throws Exception
     */
    private function calculateShippingCost(
        FormDTO $form
    ): float
    {
        $shippingCost = $this->shippingRepository->getShippingCostByZone($form->getZone());

        if ($form->getLongProduct() === true) {
            $shippingCost += self::EXTRA_SHIPPING_COST;
        }

        return $shippingCost;

    }
}
