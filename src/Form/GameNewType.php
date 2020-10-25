<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->friends = $options['friends'];

        $builder
        ->add('nom_partie',TextType::class, [
            'label' => 'Donne un nom à la partie',
            'required'   => true,
            'mapped' => false,
        ])
        ->add('friends', ChoiceType::class, [
            'choices' => $this->friends,
            'multiple' => true,
            'mapped' => false,
        ])
        ->add('themes', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'friends' => null,
        ]);
    }
}
