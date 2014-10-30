<?php

namespace fascli\BdcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class dollarType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('val','choice',array('choices' => array('1' => "1", 
                                                         '5' => "5", 
                                                         '10' => "10",
                                                         '20' => "20",
                                                         '50' => "50",
                                                         '100' => "100",
                                                         '500' => "500",
                                                         '1000' => "1000",
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('qte')
            ->add('remise')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\BdcBundle\Entity\dollar'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_bdcbundle_dollar';
    }
}
