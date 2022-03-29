<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Session;
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
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @return array<Ticket>
     */
    public function getTicketsBySession(Session $session): array
    {
        return $this->findBy([
            'session' => $session,
        ]);
    }
}
