<?php

namespace fascli\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class commissionsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debutperiode','date',array('widget'=>'single_text',
                                        'format'=>'dd-MM-yyyy',
                                        'attr'=>array('class'=>'date')))
            ->add('finperiode','date',array('widget'=>'single_text',
                                        'format'=>'dd-MM-yyyy',
                                        'attr'=>array('class'=>'date')))
            ->add('montant')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\MainBundle\Entity\commissions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_mainbundle_commissions';
    }
}
