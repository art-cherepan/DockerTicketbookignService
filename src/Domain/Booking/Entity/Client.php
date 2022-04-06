<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Uuid;

#[Entity()]
final class Client
{
    #[Id]
    #[Column(type: 'uuid')]
    private Uuid $id;

    #[Column(type: 'client_name', nullable: false)]
    private ClientName $clientName;

    #[Column(type: 'client_phone_number', nullable: false)]
    private ClientPhoneNumber $phoneNumber;

    public function __construct(
        Uuid $id,
        ClientName $clientName,
        ClientPhoneNumber $phoneNumber,
    ) {
        $this->id = $id;
        $this->clientName = $clientName;
        $this->phoneNumber = $phoneNumber;
    }

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
