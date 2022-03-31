<?php

namespace App\Domain\Booking\Entity\Exception;

class NonFreeTicketsException extends \DomainException
{
    public function __construct()
    {
        $message = 'All tickets purchased.';

        parent::__construct($message);
    }
}
