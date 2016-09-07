<?php

namespace CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'advisor',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Advisor',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => false,
                    'placeholder' => 'Berater',
                    'empty_data'  => null,
                    'required' => false
                )
            )
            ->add(
                'topic',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Topic',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => false,
                    'placeholder' => 'Thema',
                    'empty_data'  => null,
                    'required' => false
                )
            )
            ->add(
                'name',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Name',
                    'required' => false
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