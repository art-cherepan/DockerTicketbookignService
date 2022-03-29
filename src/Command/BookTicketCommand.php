<?php

namespace App\Command;

use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\Ticket;

class BookTicketCommand
{
    public function __construct(
        private Session $session,
        private Client $client,
        private Ticket $ticket,
    ) {}

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }
}
