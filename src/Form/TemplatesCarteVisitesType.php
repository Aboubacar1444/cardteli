<?php

namespace App\Form;

use App\Entity\TemplatesCarteVisites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class TemplatesCarteVisitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titres', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('descriptions', TextareaType::class, [
                'attr' => ['class' => 'form-control', "cols" => "30", "rows" => "4"]
            ])
            ->add('types', ChoiceType::class, [
                'attr' => ['class' => 'select'],
                'choices' => [
                    "Carte personnelle" => "Carte personnelle"
                ]
            ])
            ->add('images', FileType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Photos (jpg)',
                'multiple' => true,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TemplatesCarteVisites::class,
        ]);
    }
}