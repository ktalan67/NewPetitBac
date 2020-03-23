<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Manche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('manches', EntityType::class, [
            'class' => Manche::class,
            'choice_label' => 'nom',
            'expanded' => true,
            'multiple' => true,
        ]
        )
        ->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'pseudo',
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
