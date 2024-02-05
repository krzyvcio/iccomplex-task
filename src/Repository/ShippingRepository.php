<?php

namespace App\Repository;

use App\Entity\Shipping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Shipping>
 *
 * @method Shipping|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shipping|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shipping[]    findAll()
 * @method Shipping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry        $registry,
        EntityManagerInterface $em

    )

    {
        parent::__construct($registry, Shipping::class);
    }


    /**
     * @throws Exception
     */
    public function getShippingCostByZone(string $getZone): float
    {

        $shipping = $this->findOneBy(['zone' => $getZone]);
        if (null === $shipping) {
            throw new Exception('No shipping found for zone ' . $getZone);
        }
        return $shipping->getShippingCost();
    }

    public function save(Shipping $shipping): void
    {
        $this->getEntityManager()->persist($shipping);
        $this->getEntityManager()->flush();
    }
}