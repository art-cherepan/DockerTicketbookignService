<?php

namespace App\Domain\Booking\Command;

use Symfony\Component\Uid\Uuid;

class BookTicketCommand
{
    public function __construct(
        public Uuid $sessionUuid,
        public string $clientName,
        public string $clientPhoneNumber,
    ) {}

    public function getSessionUuid(): Uuid
    {
        return $this->sessionUuid;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getClientPhoneNumber(): string
    {
        return $this->clientPhoneNumber;
    }
}
