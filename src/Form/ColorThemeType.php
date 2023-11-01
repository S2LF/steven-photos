<?php

namespace App\Form;

use App\Entity\ColorThemes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColorThemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bgColor', ColorType::class, [
                'label' => 'Couleur de fond',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'bgColor'
                ]
            ])
            ->add('secondaryColor', ColorType::class, [
                'label' => 'Couleur secondaire',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'secondaryColor'
                ]
            ])
            ->add('textColor', ColorType::class, [
                'label' => 'Couleur du texte',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'textColor'
                ]
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Actif',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ColorThemes::class,
        ]);
    }
}
