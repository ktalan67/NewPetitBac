<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Feuille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeuilleVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse_1_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_2_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_3_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_4_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_5_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_6_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,
                ])
            ->add('reponse_7_score', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feuille::class,
        ]);
    }
}
