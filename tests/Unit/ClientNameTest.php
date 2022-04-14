<?php

namespace App\Tests\Unit;

use App\Domain\Booking\Entity\Exception\NonValidClientNameException;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use PHPUnit\Framework\TestCase;

class ClientNameTest extends TestCase
{
    public function testInvalidClientName(): void
    {
        self::expectException(NonValidClientNameException::class);

        new ClientName('Fake name');
    }
}
