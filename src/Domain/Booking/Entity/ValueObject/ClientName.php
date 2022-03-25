<?php

namespace App\Domain\Booking\Entity\ValueObject;

use App\Exception\NonValidClientNameException;

final class ClientName
{
    private const VALID_CLIENT_NAME_PATTERN = '/^[а-яёА-ЯЁ\s]+$/u';

    public function __construct(
        private string $value,
    ) {
        self::assertNameIsValid($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private static function assertNameIsValid(string $clientName): void
    {
        if (preg_match(self::VALID_CLIENT_NAME_PATTERN, $clientName) === 0) {
            throw new NonValidClientNameException($clientName);
        }
    }
}
