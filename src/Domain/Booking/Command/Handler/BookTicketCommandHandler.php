<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BookTicketCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ManagerRegistry $managerRegistry,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function __invoke(BookTicketCommand $command)
    {
        $clientRepository = new ClientRepository($this->managerRegistry);

        $clientName = $command->clientName;
        $clientPhoneNumber = $command->clientPhoneNumber;

        $clientNameDBType = new ClientName($clientName);
        $clientPhoneNumberDBType = new ClientPhoneNumber($clientPhoneNumber);

        $session = $command->session;

        $ticket = $session->getFreeTicket();

        $client = $clientRepository->getClient($clientNameDBType, $clientPhoneNumberDBType);

        $session->bookTicket($client, $ticket);
    }
}
