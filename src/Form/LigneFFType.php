<?php

namespace App\Form;

use App\Entity\FicheFrais;
use App\Entity\LigneFraisForfaitise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneFFType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FE', IntegerType::class, [
                'label' => 'Forfait Etape',
                'data' => $options['FE']
            ])

            ->add('FK', IntegerType::class, [
                'label' => 'Frais Kilométrique',
                'data' => $options['FK']
            ])

            ->add('NH', IntegerType::class, [
                'label' => 'Nuitée Hôtel',
                'data' => $options['NH']
            ])

            ->add('RR', IntegerType::class, [
                'label' => 'Repas Restaurant',
                'data' => $options['RR']
            ])

            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'FE' => 0,
            'FK' => 0,
            'NH' => 0,
            'RR' => 0,
        ]);
    }
}
