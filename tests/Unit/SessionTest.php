<?php

namespace App\Tests\Unit;

use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\Ticket;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

class SessionTest extends TestCase
{
    private Session $session;

    public function setUp(): void
    {
        $this->session = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            20,
        );
    }

    public function testGetCountTickets(): void
    {
        $expectedNumberOfTickets = 20;

        $session = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $expectedNumberOfTickets,
        );

        $tickets = $session->getTickets();

        self::assertEquals($expectedNumberOfTickets, count($tickets));
    }

    public function testBookTicket(): void
    {
        $clientStub = $this->createStub(Client::class);

        $ticket = $this->session->getFreeTicket();

        $this->session->bookTicket($clientStub, $ticket);

        self::assertTrue($ticket->isBooked());
    }

    public function testGetFreeTicket(): void
    {
        self::assertInstanceOf(Ticket::class, $this->session->getFreeTicket());
    }
}