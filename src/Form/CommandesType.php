<?php

namespace App\Form;

use App\Entity\Commandes;
use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Produits', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup'],
            ])
            ->add('intervention', EntityType::class, [
                'class' => Intervention::class,
                'choice_label' => function (Intervention $intervention) {
                    return $intervention->getClient()->getName() . ' - ' . $intervention->getMateriel() . ' - ' . $intervention->getProbleme();
                },
                'placeholder' => 'Aucune intervention',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commandes::class,
        ]);
    }
}