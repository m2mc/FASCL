<?php

namespace fascli\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class depensesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datdepense','date',array('widget'=>'single_text',
                                        'format'=>'dd-MM-yyyy',
                                        'attr'=>array('class'=>'date')))
            ->add('libelle')
            ->add('montant')
            ->add('caisse','choice',array('choices' => array('BDC' => "BDC", 
                                                         'WU' => "WU", 
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('autorisation','choice',array('choices' => array('DG' => "DG", 
                                                         'RAF' => "RAF", 
                                                         'CONTROLEUR' => "CONTROLEUR",
                                                         'BACKOFFICE' => "BACKOFFICE",
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('cashpoint','choice',array('choices' => array('ZRE' => "ZRE", 
                                                         'JCHO' => "JCHO", 
                                                         'SC' => "SC",
                                                         'MEN' => "MEN",
                                                         'PN' => "PN",
                                                         'TOUS' => "TOUS",
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('rubrique','choice',array('choices' => array('FTURES BUREAU' => "FTURES BUREAU", 
                                                         'CARBURANT' => "CARBURANT", 
                                                         'MAIRIE' => "MAIRIE",
                                                         'CONNEXION' => "CONNEXION",
                                                         'COMMUNICATION' => "COMMUNICATION",
                                                         'DEPLACEMENT' => "DEPLACEMENT",
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
            ->add('nfacture')
            ->add('statut','choice',array('choices' => array('PREVUE' => "PREVUE", 
                                                         'NON PREVUE' => "NON PREVUE", 
                                                         
                                            'multiple' => false, 
                                            'expanded' => false,
                                            'empty_value' => '-------'
                                            )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'fascli\MainBundle\Entity\depenses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fascli_mainbundle_depenses';
    }
}
