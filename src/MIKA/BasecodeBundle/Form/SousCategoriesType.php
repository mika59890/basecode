<?php

namespace MIKA\BasecodeBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousCategoriesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomSousCategorie',   TextType::class )
                ->add('imageSousCategorie', ImagesType::class)
                ->add('categorie', EntityType::class, array(
                    'class'         => 'MIKABasecodeBundle:Categories',
                    'choice_label'  => 'nomCategorie',
                    'multiple'      => false,))
                ->add('save',               SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MIKA\BasecodeBundle\Entity\SousCategories'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mika_basecodebundle_souscategories';
    }


}
