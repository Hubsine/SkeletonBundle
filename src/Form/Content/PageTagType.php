<?php

namespace Hubsine\SkeletonBundle\Form\Content;

use Hubsine\SkeletonBundle\Entity\Content\Page;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageTagType extends ChoiceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['choices']  = Page::getAvaiblesTags();
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefaults(
            [
                'choice_label'  => function($value, $key, $index)
                {
                    return $value;
                }
            ]
        );
    }
}
