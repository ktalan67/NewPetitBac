<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Manche;
use App\Entity\ResultatManche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ResultatMancheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('manche', EntityType::class, [
            'class' => Manche::class,
            'choice_label' => 'nom',
            'expanded' => true,
            'multiple' => true,
        ]
        )
        ->add('score', IntegerType::class)
        ->add('user', EntityType::class, [
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
            'data_class' => ResultatManche::class,
        ]);
    }
}
