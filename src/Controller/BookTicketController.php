<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Repository\SessionRepository;
use App\Form\BookSessionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookTicketController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function bookTicket(Request $request, MessageBusInterface $commandBus, SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();

        $command = new BookTicketCommand();

        $form = $this->createForm(BookSessionFormType::class, $command, ['sessions' => $sessions]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->dispatch($command);
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
