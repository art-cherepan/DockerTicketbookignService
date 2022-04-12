<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\Client;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Uid\UuidV4;

final class BookTicketCommandHandler implements MessageHandlerInterface
{
    private ClientRepository $clientRepository;

    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        $this->clientRepository = new ClientRepository($managerRegistry);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(BookTicketCommand $command)
    {
        $clientName = new ClientName($command->clientName);
        $clientPhoneNumber = new ClientPhoneNumber($command->clientPhoneNumber);

        $client = $this->getClient($clientName, $clientPhoneNumber);

        $session = $command->session;

        $ticket = $session->getFreeTicket();

        $session->bookTicket($client, $ticket);
    }

    private function getClient(ClientName $clientName, ClientPhoneNumber $clientPhoneNumber): Client
    {
        $client = $this->clientRepository->findOneBy([
            'clientName' => $clientName,
            'phoneNumber' => $clientPhoneNumber,
        ]);

        if ($client !== null) {
            return $client;
        }

        return new Client(new UuidV4(), $clientName, $clientPhoneNumber);
    }
}
