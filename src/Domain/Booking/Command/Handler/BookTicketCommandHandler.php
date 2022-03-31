<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use App\Domain\Booking\Repository\SessionRepository;
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
        $sessionRepository = new SessionRepository($this->managerRegistry);
        $clientRepository = new ClientRepository($this->managerRegistry);

        $sessionUuid = $command->getSessionUuid();
        $clientName = $command->getClientName();
        $clientPhoneNumber = $command->getClientPhoneNumber();

        $clientNameDBType = new ClientName($clientName);
        $clientPhoneNumberDBType = new ClientPhoneNumber($clientPhoneNumber);

        $session = $sessionRepository->findById($sessionUuid)[0];

        $ticket = $session->getFreeTicket();

        $client = $clientRepository->getClient($clientNameDBType, $clientPhoneNumberDBType);

        $session->bookTicket($client, $ticket);
    }
}
