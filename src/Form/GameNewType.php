<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GameNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom_partie',TextType::class, [
            'label' => 'Donne un nom à la partie',
            'required'   => true,
            'mapped' => false,
        ])
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
