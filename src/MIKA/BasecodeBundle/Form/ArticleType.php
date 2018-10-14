<?php

namespace MIKA\BasecodeBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use MIKA\BasecodeBundle\Entity\Categories;
use MIKA\BasecodeBundle\Repository\SousCategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['entity_manager'];
        $categorie = $options['categorie'];
        $builder->add('titre')
                ->add('sousCategorie',EntityType::class, array(
                    'class'         => 'MIKABasecodeBundle:SousCategories',
                    'query_builder' => function(SousCategoriesRepository $c) use($categorie){
                        return $c->choix($categorie);
                    },
                    'choice_label'  => 'nomSousCategorie',
                    'multiple'      => false,))
                ->add('contenu',CKEditorType::class, array('config_name' => 'default'))
                ->add('save',               SubmitType::class)
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MIKA\BasecodeBundle\Entity\Article'
        ));
        $resolver->setRequired(['entity_manager' ,
            'categorie',]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mika_basecodebundle_article';
    }


}
