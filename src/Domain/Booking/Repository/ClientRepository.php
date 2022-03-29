<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\UuidV4;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getClient(ClientName $clientName, ClientPhoneNumber $clientPhoneNumber): Client
    {
        $clients = $this->findBy([
            'clientName' => $clientName,
            'phoneNumber' => $clientPhoneNumber,
        ]);

        $client = null;

        if (count($clients) > 0) {
            $client = $clients[0];
        } else {
            $uuid = new UuidV4();
            $client = new Client($uuid, $clientName, $clientPhoneNumber);
        }

        return $client;
    }
}
