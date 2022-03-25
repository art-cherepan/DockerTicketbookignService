<?php

namespace App\Domain\Booking\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: TicketRepository::class)]
final class Ticket
{
    public function __construct(
        #[Id]
        #[Column(unique: true)]
        private string $id,
        #[ManyToOne(targetEntity: Session::class)]
        private Session $session,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSession(): Session
    {
        return $this->session;
    }
}
