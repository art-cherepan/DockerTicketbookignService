<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: ClientRepository::class)]
final class Client
{
    public function __construct(
        #[Id]
        #[Column(unique: true)]
        private string $id,
        #[Column(nullable: false)]
        private ClientName $clientName,
        #[Column(nullable: false)]
        private ClientPhoneNumber $phoneNumber,
    ) {}

    public function getId(): string
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
