<?php

namespace App\Form;

use App\Domain\Booking\Entity\Session;
use App\Domain\Booking\Repository\SessionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class InputDataForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public static function getSessionsInfo(SessionRepository $sessionRepository): array
    {
        $sessionsInfo = [];

        $sessions = $sessionRepository->findAll();

        foreach ($sessions as $session) {
            assert($session instanceof Session);

            $key = $session->getId()->toRfc4122();
            $value = $session->getFilmName() . ' Начало фильма: ' . gmdate('Y-m-d H:i:s', $session->getStartTime()->getTimeStamp());

            $sessionsInfo[$key] = $value;
        }

        return array_flip($sessionsInfo);
    }

    /**
     * @param array<string> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class)
            ->add('Phone', TextType::class)
            ->add('Session', ChoiceType::class, [
                'choices' => $options['data'],
            ])
            ->add('send', SubmitType::class)
            ->getForm();
    }
}
