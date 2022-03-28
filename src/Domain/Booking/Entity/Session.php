<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Repository\SessionRepository;
use App\Exception\NonFreeTicketsException;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: SessionRepository::class)]
final class Session
{
    #[OneToMany(mappedBy: 'session', targetEntity: 'Ticket', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $tickets;

    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,
        #[Column(nullable: false)]
        private string $filmName,
        #[Column(type: 'datetime_immutable', nullable: false)]
        private DateTimeImmutable $date,
        #[Column(type: 'datetime_immutable', nullable: false)]
        private DateTimeImmutable $startTime,
        #[Column(type: 'datetime_immutable', nullable: false)]
        private DateTimeImmutable $endTime,
        private int $ticketCount,
    ) {
        $this->tickets = $this->createTickets();
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

    public function bookTicket(Client $client, Ticket $ticket): BookedTicketRecord
    {
        $this->assertSessionHasAvailableTickets();
        $this->tickets->removeElement($ticket);

        return new BookedTicketRecord(Uuid::v4(), $client, $this, $ticket);
    }

    private function createTickets(): ArrayCollection
    {
        $tickets = [];

        for ($i = 0; $i < $this->ticketCount; $i++) {
            $ticket = new Ticket(Uuid::v4(), $this);
            $tickets[] = $ticket;
        }

        return new ArrayCollection($tickets);
    }

    private function assertSessionHasAvailableTickets(): void
    {
        if (!$this->tickets->count()) {
            throw new NonFreeTicketsException();
        }
    }
}
