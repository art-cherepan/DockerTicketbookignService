<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Repository\BookedTickedRecordRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity(repositoryClass: BookedTickedRecordRepository::class)]
final class BookedTicketRecord
{
    public function __construct(
        #[Id]
        #[Column(unique: true)]
        private string $id,
        #[OneToOne(targetEntity: Client::class)]
        private Client $client,
        #[OneToOne(targetEntity: Session::class)]
        private Session $session,
        #[OneToOne(targetEntity: Ticket::class)]
        private Ticket $ticket,
    ) {}

    public function getId(): string
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

    public function getFilmName(): string
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
}
