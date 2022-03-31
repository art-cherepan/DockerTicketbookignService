<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

class BookTicketCommandHandler implements MessageHandlerInterface
{
    private ClientRepository $clientRepository;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private ManagerRegistry $managerRegistry,
    ) {
        $this->clientRepository = new ClientRepository($this->managerRegistry);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(BookTicketCommand $command)
    {
        $clientName = $command->clientName;
        $clientPhoneNumber = $command->clientPhoneNumber;

        $clientNameDBType = new ClientName($clientName);
        $clientPhoneNumberDBType = new ClientPhoneNumber($clientPhoneNumber);

        $session = $command->session;

        $ticket = $session->getFreeTicket();

        $client = $this->getClient($clientNameDBType, $clientPhoneNumberDBType);

        $session->bookTicket($client, $ticket);
    }

    private function getClient(ClientName $clientName, ClientPhoneNumber $clientPhoneNumber): Client
    {
        $client = null;

        $client = $this->clientRepository->findOneBy([
            'clientName' => $clientName,
            'phoneNumber' => $clientPhoneNumber,
        ]);

        if ($client !== null) {
            return $client;
        }
            $uuid = new UuidV4();

            return new Client($uuid, $clientName, $clientPhoneNumber);
    }
}
