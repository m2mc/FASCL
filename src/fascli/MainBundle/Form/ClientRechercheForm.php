<?php

namespace fascli\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientRechercheForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motcle', 'text', array('label' => 'Nom ou Prenoms'))
            ->add('submit','submit',array('label'=>'Rechercher'));
    }
    
            
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\MainBundle\Entity\client'
        ));
    }

    public function getName()
    {
       return 'clientrecherche';
     }
}
