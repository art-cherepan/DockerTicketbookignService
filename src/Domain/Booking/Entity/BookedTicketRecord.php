<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Uid\Uuid;

#[Entity()]
class BookedTicketRecord
{
    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,
        #[ManyToOne(targetEntity: Client::class, cascade: ['persist'], inversedBy: 'id')]
        private Client $client,
        #[OneToOne(targetEntity: Ticket::class)]
        private Ticket $ticket,
    ) {
        $ticket->book($this);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSessionDate(): DateTimeImmutable
    {
        return $this->ticket->getSession()->getDate();
    }

    public function getSessionStartTime(): DateTimeImmutable
    {
        return $this->ticket->getSession()->getStartTime();
    }

    public function getSessionEndTime(): DateTimeImmutable
    {
        return $this->ticket->getSession()->getEndTime();
    }

    public function getSessionFilmName(): string
    {
        return $this->ticket->getSession()->getFilmName();
    }

    public function getClientName(): ClientName
    {
        return $this->client->getName();
    }

    public function getClientPhoneNumber(): ClientPhoneNumber
    {
        return $this->client->getPhoneNumber();
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }
}
