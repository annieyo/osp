<?php

namespace CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'name',
                TextType::class,
                array(
                    'label' => 'Name',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'topic',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Topic',
                    'placeholder' => 'Bitte wählen',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Thema',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'projectClass',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:ProjectClass',
                    'placeholder' => 'Bitte wählen',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Klasse',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'advisor',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Advisor',
                    'choice_label' => 'name',
                    'placeholder' => 'Bitte wählen',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Berater',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'product',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Produkt',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'documentation',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Dokumentation',
                    'constraints' => new NotBlank(),
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\ProjectGroup',
        ));
    }
}