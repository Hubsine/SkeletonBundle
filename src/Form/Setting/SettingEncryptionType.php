<?php

namespace Hubsine\SkeletonBundle\Form\Setting;

use Hubsine\SkeletonBundle\Entity\Setting\Email;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingEncryptionType extends ChoiceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['choices']  = Email::getEncryptions();
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
