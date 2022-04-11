<?php

namespace App\Domain\Booking\Entity\Exception;

class EmptySessionException extends \DomainException
{
    public function __construct()
    {
        $message = 'There must be at least one ticket in a session.';

        parent::__construct($message);
    }
}
