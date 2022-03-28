<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Repository\TicketRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: TicketRepository::class)]
final class Ticket
{
    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        private Uuid $id,
        #[ManyToOne(targetEntity: 'Session')]
        private Session $session,
    ) {}

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
