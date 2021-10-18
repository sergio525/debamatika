<?php

namespace App\Form;

use App\Entity\Campo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('titulo', null, ['label' => 'Título'])
            ->add('ayuda')
            ->add('unidad')
            ->add('multiple', null, [
                'label' => 'Múltiple',
                'attr' => [
                    'checked' => $entity->getMultiple()?'checked':false,
                    'class' => 'custom-control-input'
                ],
            ])          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campo::class,
        ]);
    }
}
