<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
            'label' => 'Nom',
            'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('Tel', null, [
                'label' => 'Téléphone',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('email', null, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(), // Pre-fill with current date
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'formGroup']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'attr' => ['class' => 'clientCreateForm']
        ]);
    }
}
