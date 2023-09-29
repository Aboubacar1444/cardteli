<?php

namespace App\Form;

use App\Entity\Espaces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspacesUserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userInfoSiteTemplate', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'form-control', 
                        'placeholder' => "Entrez une information"
                    ],
                    'help' => 'You can edit a name here.',
                    'label' => true
                ],
                'prototype_options'  => [
                    'help' => 'You can enter a new name here.',
                ],
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference' => false,
                'label' => false
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Espaces::class,
        ]);
    }
}