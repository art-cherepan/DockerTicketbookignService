<?php

namespace App\Domain\Booking\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Uid\Uuid;

#[Entity()]
final class Ticket
{
    #[OneToOne(targetEntity: BookedTicketRecord::class, cascade: ['persist', 'remove'])]
    private ?BookedTicketRecord $bookedTicketRecord = null;

    #[Id]
    #[Column(type: 'uuid')]
    private Uuid $id;

    #[ManyToOne(targetEntity: Session::class, inversedBy: 'tickets')]
    private Session $session;

    public function __construct(
        Uuid $id,
        Session $session,
    ) {
        $this->id = $id;
        $this->session = $session;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function book(BookedTicketRecord $bookedTicketRecord): void
    {
        $this->bookedTicketRecord = $bookedTicketRecord;
    }

    public function isBooked(): bool
    {
        return $this->bookedTicketRecord instanceof BookedTicketRecord;
    }
}
