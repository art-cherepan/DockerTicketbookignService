<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Collections\TicketCollection;
use App\Exception\NonFreeTicketsException;
use App\Repository\SessionRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: SessionRepository::class)]
final class Session
{
    private TicketCollection $tickets;

    public function __construct(
        #[Id]
        #[Column(unique: true)]
        private string $id,
        #[Column(type: 'integer', nullable: false)]
        private int $numberOfTickets,
        #[Column(nullable: false)]
        private string $filmName,
        #[Column(type: 'datetime', nullable: false)]
        private DateTime $date,
        #[Column(type: 'datetime', nullable: false)]
        private DateTime $startTime,
        #[Column(type: 'datetime', nullable: false)]
        private DateTime $endTime,
    ) {
        $this->tickets = $this->createTickets($this->numberOfTickets);
    }

    public function getId(): string
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
        self::assertSessionHasAvailableTickets($this);

        $this->tickets = $this->getTickets()->withoutTicket($ticket);

        return new BookedTicketRecord(Uuid::v4(), $client, $this, $ticket);
    }

    public function getTickets(): TicketCollection
    {
        return $this->tickets;
    }

    private function createTickets(int $numberOfTickets): TicketCollection
    {
        $tickets = [];

        for ($i = 0; $i < $numberOfTickets; $i++) {
            $tickets[] = new Ticket(Uuid::v4(), $this);
        }

        return new TicketCollection($tickets);
    }

    private static function assertSessionHasAvailableTickets(Session $session): void
    {
        if (!$session->getTickets()->count()) {
            throw new NonFreeTicketsException();
        }
    }
}
