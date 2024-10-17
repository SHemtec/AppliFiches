<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Materiel', TextType::class, [
                'label' => 'Matériel',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('MdpSession', TextType::class, [
                'label' => 'Mot de passe session',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('Probleme', TextareaType::class, [
                'label' => 'Problème',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('Operations', TextareaType::class, [
                'label' => 'Opérations',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('Cout', NumberType::class, [
                'label' => 'Coût',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('Nettoyage', CheckboxType::class, [
                'label' => 'Nettoyage',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
                'row_attr' => ['class' => 'formGroupCheckbox'],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Non traité' => 0,
                    'En cours' => 1,
                    'Terminé' => 2,
                ],
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',
                'label' => 'Client',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup'],
                'data' => $options['data']->getClient(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
            'attr' => ['class' => 'interventionCreateForm'],
            'client' => null
        ]);
    }
}