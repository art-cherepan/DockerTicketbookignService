<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\ValueObject\ClientName;
use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use App\Domain\Booking\Repository\ClientRepository;
use App\Domain\Booking\Repository\SessionRepository;
use App\Form\InputDataForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CommandBusController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function index(
        Request $request,
        MessageBusInterface $commandBus,
        SessionRepository $sessionRepository,
        ClientRepository $clientRepository,
    ): Response {
        $sessionsInfo = $sessionRepository->getSessionsInfo();

        $form = $this->createForm(InputDataForm::class, $sessionsInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $sessionUuid = new Uuid($formData['Session']);

            $session = $sessionRepository->findById($sessionUuid)[0];

            $ticket = $session->getFreeTicket();

            $clientName = new ClientName($formData['Name']);
            $phoneNumber = new ClientPhoneNumber($formData['Phone']);

            $client = $clientRepository->getClient($clientName, $phoneNumber);

            $commandBus->dispatch(new BookTicketCommand($session, $client, $ticket));
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
