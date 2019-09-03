<?php

namespace Hubsine\SkeletonBundle\Form\Appearance;

use Hubsine\SkeletonBundle\Entity\Appearance\Site;
use Hubsine\SkeletonBundle\Form\Appearance\SiteTranslationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('translation', SiteTranslationType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
