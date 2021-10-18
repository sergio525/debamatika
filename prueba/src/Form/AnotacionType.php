<?php

namespace App\Form;

use App\Entity\Anotacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnotacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observaciones', null, [
                'label' => 'Observaciones',
            ])
            ->add('imagen', null, [
                'label' => false,
                'attr' => [
                    'style' => 'display: none',
                ]
            ])
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Anotacion::class,
        ]);
    }
}
