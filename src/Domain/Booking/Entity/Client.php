<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ClientRepository::class)]
final class Client
{
    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,
        #[Column(type: 'clientname', nullable: false)]
        private ClientName $clientName,
        #[Column(type: 'clientphonenumber', nullable: false)]
        private ClientPhoneNumber $phoneNumber,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): ClientName
    {
        return $this->clientName;
    }

    public function getPhoneNumber(): ClientPhoneNumber
    {
        return $this->phoneNumber;
    }
}
