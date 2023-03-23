<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheFraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Mois:',ChoiceType::class, [
                'choices' =>
                    $options['mois_list'],
                'choice_label' => function ($choice, $key, $value) {
                    return $value;}
            ])
            ->add('valide', SubmitType::class, [
                'label' => 'Je valide',
                'attr' => [
                    'class' => 'btn btn-primary', //ex d'ajout de classes Bootstrap
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mois_list' => [],
        ]);
    }
}
