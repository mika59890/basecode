<?php
/**
 * Created by PhpStorm.
 * User: wolverine
 * Date: 03/06/2018
 * Time: 09:44
 */
namespace MIKA\BasecodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CkeditorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'ckeditor') // On ajoute la classe CSS
        ));
    }

    public function getParent() // On utilise l'héritage de formulaire
    {
        return TextareaType::class;
    }
}