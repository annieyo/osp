<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => 'Vor- und Nachname',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'discussion',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Fachgespräch',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                                'pattern'   => '/[1-6]{1}[+-]?/',
                                'match'     => true,
                        )),
                    )
                )
            )
            ->add(
                'presentation',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Präsentation',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                            'pattern'   => '/[1-6]{1}[+-]?/',
                            'match'     => true,
                        )),
                    )
                )
            )
            ->add(
                'totalGso',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Gesamtnote GSO',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                            'pattern'   => '/[1-6]{1}[+-]?/',
                            'match'     => true,
                        )),
                    )
                )
            )
            ->add(
                'totalIhk',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Gesamtnote IHK',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                            'pattern'   => '/[1-6]{1}[+-]?/',
                            'match'     => true,
                        )),
                    )
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
                    'label'    => false,
                    'data' => 0
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