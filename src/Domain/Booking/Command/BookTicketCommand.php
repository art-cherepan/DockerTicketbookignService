<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\Session;
use Symfony\Component\Validator\Constraints as Assert;

class BookTicketCommand
{
    public ?Session $session;

    #[Assert\Regex(
        pattern: '/^[а-яёА-ЯЁ\s]+$/u',
        match: true,
        message: 'The name must contain only Russian letters.',
    )]
    #[Assert\NotBlank]
    public ?string $clientName = 'Иван';

    #[Assert\Regex(
        pattern: '/^[0-9]{10,10}+$/',
        match: true,
        message: 'Phone number must contain 10 digits.',
    )]
    #[Assert\NotBlank]
    public ?string $clientPhoneNumber = '1234567891';
}
