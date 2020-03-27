<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'username',
            'expanded' => true,
            'multiple' => true,
        ]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
