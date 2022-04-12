<?php

namespace App\Fixture;

use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class ClientFixture extends Fixture
{
    private const REFERENCE = 'client';

    public function load(ObjectManager $manager): void
    {
        $client = new Client(Uuid::v4(), new ClientName('Иван'), new ClientPhoneNumber('8914999999'));

        $manager->persist($client);
        $manager->flush();

        $this->addReference(self::REFERENCE, $client);
    }
}
