<?php

namespace CoreBundle\Form;

use Doctrine\ORM\EntityRepository;
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
                    'query_builder' => function(EntityRepository $repository) {
                        return $repository->createQueryBuilder('a')->orderBy('a.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => false,
                    'placeholder' => 'Betreuer',
                    'empty_data'  => null,
                    'required' => false
                )
            )
            ->add(
                'topic',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Topic',
                    'query_builder' => function(EntityRepository $repository) {
                        return $repository->createQueryBuilder('t')->orderBy('t.name', 'ASC');
                    },
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
                    'label' => 'Schülername',
                    'required' => false
                )
            )->setMethod('GET');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\ProjectGroup',
        ));
    }
}