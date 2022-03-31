<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\Session;

class BookTicketCommand
{
    public ?Session $session;

    #[Assert\Regex(
        pattern: '/^[а-яёА-ЯЁ\s]+$/u',
        match: true,
        message: 'The name must contain only Russian letters.',
    )]
    public string $clientName;

    #[Assert\Regex(
        pattern: '/^[0-9]{10,10}+$/',
        match: true,
        message: 'Phone number must contain 10 digits.',
    )]
    public string $clientPhoneNumber;
}
