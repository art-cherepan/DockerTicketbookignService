<?php

namespace App\Tests\Unit;

use App\Domain\Booking\Entity\BookedTicketRecord;
use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\Exception\EmptySessionException;
use App\Domain\Booking\Entity\Exception\NonFreeTicketsException;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\Ticket;
use AssertionError;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

class SessionTest extends TestCase
{
    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();

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

    public function testGetFreeTicketInSessionWithoutTickets(): void
    {
        self::expectException(NonFreeTicketsException::class);

        $numberOfTickets = 1;

        $session = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $numberOfTickets,
        );

        $clientStub = $this->createStub(Client::class);

        $ticketOne = $session->getFreeTicket();

        $session->bookTicket($clientStub, $ticketOne);

        $session->getFreeTicket();
    }

    public function testPassZeroTicketsToTheSession(): void
    {
        self::expectException(EmptySessionException::class);

        $numberOfTickets = 0;

        new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $numberOfTickets,
        );
    }

    public function testBookTicketInAnotherSession(): void
    {
        self::expectException(AssertionError::class);

        $numberOfTickets = 5;

        $sessionOne = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $numberOfTickets,
        );

        $sessionTwo = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $numberOfTickets,
        );

        $clientStub = $this->createStub(Client::class);

        $ticket = $sessionOne->getFreeTicket();

        $sessionTwo->bookTicket($clientStub, $ticket);
    }

    public function testBookBookedTicket(): void
    {
        self::expectException(AssertionError::class);

        $numberOfTickets = 5;

        $session = new Session(
            new UuidV4(),
            'Веном 1',
            new DateTimeImmutable('2022-04-01'),
            new DateTimeImmutable('2022-04-01 20:00:00'),
            new DateTimeImmutable('2022-04-01 22:30:00'),
            $numberOfTickets,
        );

        $clientStub = $this->createStub(Client::class);

        $ticketStub = $this->createStub(Ticket::class);

        $bookedTicketRecordStub = $this->createStub(BookedTicketRecord::class);

        $ticketStub->book($bookedTicketRecordStub);

        $session->bookTicket($clientStub, $ticketStub);
    }
}
