<?php

namespace App\Domain\Booking\Entity\Exception;

class NonValidClientPhoneException extends \DomainException
{
    public function __construct(string $nonValidPhone)
    {
        $message = sprintf('The number of phone "%s" have not a valid format.', $nonValidPhone);

        parent::__construct($message);
    }
}
