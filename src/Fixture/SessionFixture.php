<?php

namespace App\Fixture;

use App\Domain\Booking\Entity\Session;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\UuidV4;

class SessionFixture extends Fixture
{
    private const REFERENCE_SESSION = 'session';

    public function load(ObjectManager $manager): void
    {
        $ticketCount = 50;

        $id = new UuidV4();
        $filmName = 'Веном 1';
        $date = new DateTimeImmutable('2022-04-01 00:00:00');
        $timeStart = new DateTimeImmutable('2022-04-01 00:00:00');
        $timeEnd = new DateTimeImmutable('2022-04-01 22:30:00');

        $session = new Session($id, $filmName, $date, $timeStart, $timeEnd, $ticketCount);

        $manager->persist($session);
        $manager->flush();

        $this->addReference(self::REFERENCE_SESSION, $session);
    }
}
