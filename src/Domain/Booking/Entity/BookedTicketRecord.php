<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\BookedTickedRecordRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: BookedTickedRecordRepository::class)]
final class BookedTicketRecord
{
    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,
        #[OneToOne(targetEntity: Client::class)]
        private Client $client,
        #[OneToOne(targetEntity: Session::class)]
        private Session $session,
        #[OneToOne(targetEntity: Ticket::class)]
        private Ticket $ticket,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSessionDate(): DateTimeImmutable
    {
        return $this->session->getDate();
    }

    public function getSessionStartTime(): DateTimeImmutable
    {
        return $this->session->getStartTime();
    }

    public function getSessionEndTime(): DateTimeImmutable
    {
        return $this->session->getEndTime();
    }

    public function getSessionFilmName(): string
    {
        return $this->session->getFilmName();
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
