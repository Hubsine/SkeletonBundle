<?php

namespace Hubsine\SkeletonBundle\Form\Appearance;

use Hubsine\SkeletonBundle\Entity\Appearance\SiteTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slogan')
            ->add('description')
            ->add('locale')
            #->add('objectClass')
            #->add('field')
            #->add('foreignKey')
            #->add('content')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteTranslation::class,
        ]);
    }
}
