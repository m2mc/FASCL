<?php

namespace fascli\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class operationsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type','choice',array('choices' => array('ENVOI' => "ENVOI", 
                                                         'PAIEMENT' => "PAIEMENT", 
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('montant')
            ->add('piece','choice',array('choices' => array('CNI' => "CNI", 
                                                            'PASSPORT' => "PASSPORT", 
                                                            'CARTE CONSULAIRE' => "CARTE CONSULAIRE",
                                                            'CARTE PROFESSIONNELLE' => "CARTE PROFESSIONNELLE",
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('npiece')
            ->add('expdate','date',array('widget'=>'single_text',
                                        'format'=>'dd-MM-yyyy',
                                        'attr'=>array('class'=>'date')))
            ->add('client', 'entity', array(
                                    'class' => 'fascliMainBundle:client',
                                    'query_builder' => function(\fascli\MainBundle\Repository\clientRepository $er) {
                                    return $er->createQueryBuilder('c')
                                    ->orderBy('c.nom', 'ASC');
                                    },
                                    ))
                                            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\MainBundle\Entity\operations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_mainbundle_operations';
    }
}
