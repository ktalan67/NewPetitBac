<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Feuille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeuilleNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse_1')
            ->add('reponse_2')
            ->add('reponse_3')
            ->add('reponse_4')
            ->add('reponse_5')
            ->add('reponse_6')
            ->add('reponse_7')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feuille::class,
        ]);
    }
}
