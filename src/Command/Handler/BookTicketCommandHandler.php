<?php

namespace App\Command\Handler;

use App\Command\BookTicketCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BookTicketCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function __invoke(BookTicketCommand $command)
    {
        $session = $command->getSession();
        $client = $command->getClient();
        $ticket = $command->getTicket();

        $session->bookTicket($client, $ticket);

        $this->entityManager->flush();
    }
}
