<?php

namespace CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'selectedGroup',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:ProjectGroup',
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'mapped' => false,
                    'placeholder' => "Bitte wählen",
                    'label' => 'Gruppe wählen',
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