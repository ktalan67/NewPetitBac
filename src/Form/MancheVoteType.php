<?php

namespace App\Form;

use App\Entity\Feuille;
use App\Repository\FeuilleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MancheVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse_1_vote', EntityType::class, [
            'class' => Feuille::class,
            'choice_label' => function(Feuille $feuille) {
                return sprintf('(%d) %s', $feuille->getId(), $feuille->getEmail());
            },
            'placeholder' => 'Choisir la meilleur réponse',
            'choices' => $this->feuilleRepository->findBy(['manche' => $manche, 'reponse_1']),
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
