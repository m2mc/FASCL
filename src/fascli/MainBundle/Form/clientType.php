<?php

namespace fascli\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class clientType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenoms')
            ->add('datnaissance','date',array('widget'=>'single_text',
                                        'format'=>'dd-MM-yyyy',
                                        'attr'=>array('class'=>'date')))
            ->add('sexe','choice',array('choices' => array('M' => "M", 
                                                         'F' => "F", 
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('nationalite','choice',array('choices' => array('BENINOISE' => "BENINOISE", 
                                                         'TOGOLAISE' => "TOGOLAISE", 
                                                         'NIGERIENNE' => "NIGERIENNE", 
                                                         'MALIENNE' => "MALIENNE", 
                                                         'NIGERIANE' => "NIGERIANE", 
                                                         'FRANCAISE' => "FRANCAISE", 
                                                         'AMERICAINE' => "AMERICAINE", 
                                                         'SUISSE' => "SUISSE", 
                                                         'SENEGALAISE' => "SENEGALAISE", 
                                                         'BURKINABAISE' => "BURKINABAISE",
                                                         'ALLEMANDE' => "ALLEMANDE",  
                                                         
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('telephone')
            ->add('profession')
            ->add('adresse')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\MainBundle\Entity\client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_mainbundle_client';
    }
}
