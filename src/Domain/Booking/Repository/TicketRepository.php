<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<Ticket>
     */
    public function findAll(): array
    {
        return parent::findAll();
    }
}
