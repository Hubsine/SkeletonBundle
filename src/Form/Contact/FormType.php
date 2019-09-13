<?php

namespace Hubsine\SkeletonBundle\Form\Contact;

use Hubsine\SkeletonBundle\Entity\Contact\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail', 
                #'required'  => true
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'required'  => true
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'required'  => true
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required'  => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Form::class,
        ]);
    }
}
