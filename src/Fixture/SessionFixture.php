<?php

namespace App\Fixture;

use App\Domain\Booking\Entity\Session;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\UuidV4;

class SessionFixture extends Fixture
{
    private const REFERENCE_SESSION_FIRST = 'sessionFirst';
    private const REFERENCE_SESSION_SECOND = 'sessionSecond';

    public function load(ObjectManager $manager): void
    {
        $id = new UuidV4();
        $filmName = 'Веном 1';
        $ticketCount = 20;
        $date = new DateTimeImmutable('2022-04-01 00:00:00');
        $timeStart = new DateTimeImmutable('2022-04-01 00:00:00');
        $timeEnd = new DateTimeImmutable('2022-04-01 22:30:00');

        $sessionFirst = new Session($id, $filmName, $date, $timeStart, $timeEnd, $ticketCount);

        $id = new UuidV4();
        $filmName = 'Веном 2';
        $ticketCount = 30;
        $date = new DateTimeImmutable('2022-04-02 00:00:00');
        $timeStart = new DateTimeImmutable('2022-04-02 00:00:00');
        $timeEnd = new DateTimeImmutable('2022-04-02 22:30:00');

        $sessionSecond = new Session($id, $filmName, $date, $timeStart, $timeEnd, $ticketCount);

        $manager->persist($sessionFirst);
        $manager->persist($sessionSecond);
        $manager->flush();

        $this->addReference(self::REFERENCE_SESSION_FIRST, $sessionFirst);
        $this->addReference(self::REFERENCE_SESSION_SECOND, $sessionSecond);
    }
}
