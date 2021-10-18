<?php

namespace App\Form;

use App\Entity\Informe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroPedido', null, ['label' => 'Nº de pedido / O.F.'])
            ->add('numeroRevision', null, ['label' => 'Nº de revisión'])
            ->add('fecha')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Informe::class,
        ]);
    }
}
