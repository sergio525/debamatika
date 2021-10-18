<?php

namespace App\Form;

use App\Entity\EquipoInstalado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoInstaladoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion')
            ->add('idMaquina', null, ['label' => 'Id. Máquina'])
            ->add('numeroRevision', null, ['label' => 'Nº de Revisión'])
            ->add('tipoEquipo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EquipoInstalado::class,
        ]);
    }
}
