<?php

namespace App\Domain\Booking\Entity\Exception;

final class NonFreeTicketsException extends \DomainException
{
    public function __construct()
    {
        $message = 'Sorry, all tickets purchased :(';

        parent::__construct($message);
    }
}
