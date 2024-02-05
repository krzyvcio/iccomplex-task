<?php
declare(strict_types=1);

namespace App\Service\PricingService;

use App\Data\ZonesShippingCostsData;
use App\Entity\Zone;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;

class PricingService
{

    public function __construct(
        private readonly ZoneRepository         $zonesRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {

    }

    public function importZonesShippingCosts(ZonesShippingCostsData $zonesShippingCosts): void
    {
        //begin transaction
        $this->entityManager->beginTransaction();


        foreach ($zonesShippingCosts->getRows() as $row) {
            $zone = (new Zone())
                ->setName($row->getZone())
                ->setShippingCost($row->getShippingCost());

            $this->zonesRepository->save($zone);
        }
        $this->entityManager->flush();
        $this->entityManager->commit();

    }
}