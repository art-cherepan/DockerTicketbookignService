<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Exception\EmptySessionException;
use App\Domain\Booking\Entity\Exception\NonFreeTicketsException;
use App\Domain\Booking\Repository\SessionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

#[Entity(repositoryClass: SessionRepository::class)]
/**
 * @final
 */
class Session
{
    #[Id]
    #[Column(type: 'uuid')]
    private Uuid $id;

    #[Column(nullable: false)]
    private string $filmName;

    #[Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $date;

    #[Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $startTime;

    #[Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $endTime;

    #[OneToMany(mappedBy: 'session', targetEntity: Ticket::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $tickets;

    public function __construct(
        Uuid $id,
        string $filmName,
        DateTimeImmutable $date,
        DateTimeImmutable $startTime,
        DateTimeImmutable $endTime,
        int $ticketCount,
    ) {
        $this->id = $id;
        $this->filmName = $filmName;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->tickets = $this->createTickets($ticketCount);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getStartTime(): DateTimeImmutable
    {
        return $this->startTime;
    }

    public function getEndTime(): DateTimeImmutable
    {
        return $this->endTime;
    }

    public function getFilmName(): string
    {
        return $this->filmName;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function bookTicket(Client $client, Ticket $ticket): void
    {
        $uuid = new UuidV4();
        $bookedTicketRecord = new BookedTicketRecord($uuid, $client, $ticket);
        $ticket->book($bookedTicketRecord);
    }

    public function getFreeTicket(): Ticket
    {
        $freeTickets = $this->getFreeTickets();

        if (count($freeTickets) === 0) {
            throw new NonFreeTicketsException();
        }

        return $freeTickets->first();
    }

    private function getFreeTickets(): Collection
    {
        return $this->getTickets()->filter(static fn (Ticket $ticket) => !$ticket->isBooked());
    }

    private function createTickets(int $ticketCount): ArrayCollection
    {
        if ($ticketCount === 0) {
            throw new EmptySessionException();
        }

        $tickets = [];

        for ($i = 0; $i < $ticketCount; $i++) {
            $ticket = new Ticket(Uuid::v4(), $this);
            $tickets[] = $ticket;
        }

        return new ArrayCollection($tickets);
    }

    private function hasAFreeTicket(): bool
    {
        $tickets = $this->getTickets();

        foreach ($tickets as $ticket) {
            if ($ticket->isBooked() === false) {
                return true;
            }
        }

        return false;
    }
}
