<?php

namespace fascli\BdcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use fascli\BdcBundle\Form\suisseType;

class operationssuisseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client')
            ->add('suisses', 'collection', array(
        'type' => new suisseType(),
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'by_reference' => false,
        'attr'=>array('class'=>'form-inline'),
    ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\BdcBundle\Entity\operationsbdc'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_bdcbundle_suisse_operations';
    }
}
