<?php

namespace App\Tests\Functional;

use App\Domain\Booking\Entity\Session;
use App\Fixture\SessionFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookedTicketControllerTest extends WebTestCase
{
    private AbstractDatabaseTool $databaseTool;
    private EntityManagerInterface $entityManager;
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
        $this->databaseTool->loadFixtures(
            [SessionFixture::class],
        );

        $session = $this->entityManager->getRepository(Session::class)->findOneBy(['filmName' => 'Веном 1']);
        $sessionId = $session->getId();

        $this->client->request('GET', 'http://localhost/');
        $this->client->submitForm('book_session_form[submit]', [
            'book_session_form[clientName]' => 'Иван',
            'book_session_form[clientPhoneNumber]' => '1234567899',
            'book_session_form[session]' => $sessionId,
        ]);

        self::assertResponseIsSuccessful();
    }
}
