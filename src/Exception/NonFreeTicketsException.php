<?php

namespace App\Exception;

class NonFreeTicketsException extends \DomainException
{
    public function __construct()
    {
        $message = 'All tickets purchased.';

        parent::__construct($message);
    }
}
