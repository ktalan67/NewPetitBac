<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Feuille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FeuilleVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse_1_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_2_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_3_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_4_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_5_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_6_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
            ->add('reponse_7_score', ChoiceType::class, [
                'choices'  => [
                    'MDRRR' => 3,
                    'Validé' => 1,
                    'Nope.' => 0,
            ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feuille::class,
        ]);
    }
}
