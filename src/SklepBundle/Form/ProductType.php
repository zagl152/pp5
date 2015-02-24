<?php

namespace SklepBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                "label"=>"Podaj  tytuł"
            ))
            ->add('actors', null, array(
                "label"=>"Podaj  aktorow"
            ))
            ->add('description', null, array(
                "attr"=>array("rows" => 8),
                "label"=>"Opis filmu"
            ))
            ->add('price', null, array(
                "label"=>"Podaj  cene"
            ))
            ->add('photo', 'iphp_file',  array(
                "label"=>"Dodaj plakat"
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SklepBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sklepbundle_product';
    }
}
