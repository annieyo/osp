<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

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
                        new Range(array(
                            'min'        => 1,
                            'max'        => 6,
                            'minMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                            'maxMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                        ))
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
                        new Range(array(
                            'min'        => 1,
                            'max'        => 6,
                            'minMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                            'maxMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                        ))
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
                        new Range(array(
                            'min'        => 1,
                            'max'        => 6,
                            'minMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                            'maxMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                        ))
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
                        new Range(array(
                            'min'        => 1,
                            'max'        => 6,
                            'minMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                            'maxMessage' => 'Bitte eine Wert zwischen 1 und 6 wählen.',
                        ))
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