<?php

namespace App\Tests\Functional;

use App\Domain\Booking\Entity\Session;
use App\Fixture\SessionFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTicketControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testMainPageIsAvailable(): void
    {
        $this->client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    public function testBookTicket(): void
    {
        $referenceRepository = $this->databaseTool
            ->loadFixtures([SessionFixture::class])
            ->getReferenceRepository();

        $session = $referenceRepository->getReference(SessionFixture::REFERENCE_SESSION);
        assert($session instanceof Session);

        $this->client->request('GET', 'http://localhost/');
        $this->client->submitForm('submit', [
            'book_session_form[clientName]' => 'Андрей',
            'book_session_form[clientPhoneNumber]' => '1234567889',
            'book_session_form[session]' => $session->getId(),
        ]);

        self::assertResponseIsSuccessful();
    }
}
