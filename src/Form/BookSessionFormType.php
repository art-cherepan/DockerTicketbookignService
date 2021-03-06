<?php

namespace App\Form;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BookSessionFormType extends AbstractType
{
    /**
     * @param array<string> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $sessions = $options['sessions'];

        $builder
            ->add('clientName', TextType::class, [
                'label' => 'Введите ваше имя: ',
                'attr' => ['class' => 'mt-2 mb-2'],
            ])
            ->add('clientPhoneNumber', TextType::class, [
                'label' => 'Введите номер телефона: ',
                'attr' => ['class' => 'mt-2 mb-2'],
            ])
            ->add('session', EntityType::class, [
                'label' => 'Выберите сеанс: ',
                'class' => Session::class,
                'choice_label' => static fn (Session $session) => $session->getFilmName() . ' Начало фильма: ' .
                    gmdate('Y-m-d H:i:s', $session->getStartTime()->getTimeStamp()),
                'choices' => $sessions,
                'attr' => ['class' => 'mt-2 mb-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => BookTicketCommand::class,
            'sessions' => [],
        ]);
    }
}
