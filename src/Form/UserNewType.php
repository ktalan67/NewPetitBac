<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Manche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class, [
            'constraints' => new NotBlank()
        ])
            //->add('experience')
            //->add('meilleur_score')
            //->add('avatar')
            ->add('password', TextType::class, [
                'constraints' => new NotBlank()
            ])
            //->add('experience')
            //->add('meilleur_score')
            //->add('avatar')
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
