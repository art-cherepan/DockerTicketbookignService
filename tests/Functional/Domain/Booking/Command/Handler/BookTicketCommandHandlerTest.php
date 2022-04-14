<?php

namespace App\Tests\Functional\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\BookedTicketRecord;
use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\BookedTicketRecordRepository;
use App\Domain\Booking\Repository\ClientRepository;
use App\Fixture\SessionFixture;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookTicketCommandHandlerTest extends WebTestCase
{
    private AbstractDatabaseTool $databaseTool;
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;
    private BookedTicketRecordRepository $bookedTicketRecordRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $this->clientRepository = $this->entityManager->getRepository(Client::class);
        $this->bookedTicketRecordRepository = $this->entityManager->getRepository(BookedTicketRecord::class);
    }

    public function testCommandExecute(): void
    {
        $referenceRepository = $this->databaseTool
            ->loadFixtures([SessionFixture::class])
            ->getReferenceRepository();

        $session = $referenceRepository->getReference(SessionFixture::REFERENCE_SESSION);
        assert($session instanceof Session);

        $command = new BookTicketCommand();

        $command->session = $session;
        $command->clientName = 'Иван';
        $command->clientPhoneNumber = '1234567891';

        $commandBus = $this->getContainer()->get('debug.traced.command_bus');

        $commandBus->dispatch($command);

        $client = $this->clientRepository->findOneBy([
            'clientName' => new ClientName($command->clientName),
            'phoneNumber' => new ClientPhoneNumber($command->clientPhoneNumber),
        ]);

        self::assertInstanceOf(Client::class, $client);

        $bookedTicketRecord = $this->bookedTicketRecordRepository->findOneBy([
            'client' => $client,
        ]);

        self::assertInstanceOf(BookedTicketRecord::class, $bookedTicketRecord);
    }
}
