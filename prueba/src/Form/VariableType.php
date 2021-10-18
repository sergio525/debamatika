<?php

namespace App\Form;

use App\Entity\Variable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valorDefecto', null, [
                'label' => false,
                'attr' => [
                    'style' => 'display: none',
                ]
            ])
            ->add('tipoCampo', null, ['label' => 'Tipo'])
            ->add('valor', null, [
                'mapped' => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Variable::class,
        ]);
    }
}
