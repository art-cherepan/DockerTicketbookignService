<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Repository\SessionRepository;
use App\Form\InputDataForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class BookTicketController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function book(
        Request $request,
        MessageBusInterface $commandBus,
        SessionRepository $sessionRepository,
    ): Response {
        $sessionsInfo = InputDataForm::getSessionsInfo($sessionRepository);

        $form = $this->createForm(InputDataForm::class, $sessionsInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $sessionUuid = new Uuid($formData['Session']);

            $clientName = (string) $formData['Name'];
            $phoneNumber = (string) $formData['Phone'];

            $commandBus->dispatch(new BookTicketCommand($sessionUuid, $clientName, $phoneNumber));
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
