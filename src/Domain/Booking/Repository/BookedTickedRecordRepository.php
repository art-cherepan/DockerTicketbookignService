<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\BookedTicketRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookedTickedRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookedTicketRecord::class);
    }
}
