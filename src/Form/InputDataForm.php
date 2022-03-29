<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class InputDataForm extends AbstractType
{
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
