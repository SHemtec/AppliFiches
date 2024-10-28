<?php

namespace App\Form;

use App\Entity\Intervention;
use App\Entity\Test;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre')
            ->add('Description')
            ->add('intervention', EntityType::class, [
                'class' => Intervention::class,
                'choice_label' => function (Intervention $intervention) {
                    return $intervention->getClient()->getName() . ' - ' . $intervention->getMateriel() . ' - ' . $intervention->getProbleme();
                },
            ])
            ->add('photoFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'label' => 'Upload Photo',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}