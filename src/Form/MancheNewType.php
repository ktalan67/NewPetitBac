<?php

namespace App\Form;

use App\Entity\Manche;
use App\Entity\User;
use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MancheNewType extends AbstractType
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
        ->add('theme', EntityType::class, [
            'class' => Theme::class,
            'choice_label' => 'nom',
            'expanded' => true,
            'multiple' => true,
        ]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manche::class,
        ]);
    }
}
