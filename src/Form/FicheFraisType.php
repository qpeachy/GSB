<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheFraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mois',ChoiceType::class, [
                'label' => 'Mois :',
                'choices' =>
                    $options['mois_list'],
                'choice_label' => function ($choice, $key, $value) {
                    return $value;}
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary', //ex d'ajout de classes Bootstrap
                ]
            ])
            ->add('effacer', SubmitType::class,[
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
