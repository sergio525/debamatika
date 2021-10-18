<?php

namespace App\Form;

use App\Entity\Plantilla;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlantillaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('visible', null, [
                'label' => false,
                
                'attr' => [
                    'checked' => $entity->getVisible()?'checked':false,
                    'class' => 'custom-control-input plantilla-visible',
                    'data-id' => $entity->getId(),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plantilla::class,
        ]);
    }
}
