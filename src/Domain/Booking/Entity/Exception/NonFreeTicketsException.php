<?php

namespace App\Domain\Booking\Entity\Exception;

class NonFreeTicketsException extends \DomainException
{
    public function __construct()
    {
        $message = 'Sorry, all tickets purchased :(';

        parent::__construct($message);
    }
}
