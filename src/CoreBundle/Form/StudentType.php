<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => 'Name',
                )
            )
            ->add(
                'first_name',
                TextType::class,
                array(
                    'label' => 'Vorname',
                )
            )
            ->add(
                'discussion',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Fachgespräch',
                )
            )
            ->add(
                'presentation',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Präsentation',
                )
            )
            ->add(
                'group_exists',
                ChoiceType::class, array(
                    'choices'  => array(
                        'bestehende' => false,
                        'neue Gruppe' => true,
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'mapped'   => false,
                    'label'    => false
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Student',
        ));
    }
}