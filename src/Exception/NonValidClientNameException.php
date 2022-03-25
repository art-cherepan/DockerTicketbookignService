<?php

namespace App\Exception;

class NonValidClientNameException extends \DomainException
{
    public function __construct(string $nonValidName)
    {
        $message = sprintf('The family name "%s" have not a valid format.', $nonValidName);

        parent::__construct($message);
    }
}
