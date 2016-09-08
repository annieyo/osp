<?php

namespace CoreBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                    'query_builder' => function(EntityRepository $repository) {
                        return $repository->createQueryBuilder('t')->orderBy('t.name', 'ASC');
                    },
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
                    'query_builder' => function(EntityRepository $repository) {
                        return $repository->createQueryBuilder('a')->orderBy('a.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'placeholder' => 'Bitte wählen',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Betreuer',
                    'constraints' => new NotBlank(),
                )
            )
            ->add(
                'product',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Produkt',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                            'pattern'   => '/^[1-6][+-]{0,1}$/',
                            'match'     => true,
                        )),
                    )
                )
            )
            ->add(
                'documentation',
                TextType::class,
                array(
                    'mapped' => false,
                    'label' => 'Dokumentation',
                    'constraints' => array(
                        new NotBlank(),
                        new Regex(array(
                            'pattern'   => '/^[1-6][+-]{0,1}$/',
                            'match'     => true,
                        )),
                    )
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