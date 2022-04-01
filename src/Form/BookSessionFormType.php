<?php

namespace App\Form;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookSessionFormType extends AbstractType
{
    /**
     * @param array<string> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $sessions = $options['sessions'];

        $builder
            ->add('clientName', TextType::class, [
                'label' => 'Введите ваше имя: ',
            ])
            ->add('clientPhoneNumber', TextType::class, [
                'label' => 'Введите номер телефона: ',
            ])
            ->add('session', EntityType::class, [
                'label' => 'Выберите сеанс: ',
                'class' => Session::class,
                'choice_label' => static fn (Session $session) => $session->getFilmName() . ' Начало фильма: ' .
                    gmdate('Y-m-d H:i:s', $session->getStartTime()->getTimeStamp()),
                'choices' => $sessions,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookTicketCommand::class,
            'sessions' => [],
        ]);
    }
}
