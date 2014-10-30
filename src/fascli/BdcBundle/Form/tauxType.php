<?php

namespace fascli\BdcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class tauxType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ea')
            ->add('ev')
            ->add('da')
            ->add('dv')
            ->add('ga')
            ->add('gv')
            ->add('sa')
            ->add('sv')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\BdcBundle\Entity\taux'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_bdcbundle_taux';
    }
}
