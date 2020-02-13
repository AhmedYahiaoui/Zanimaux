<?php

namespace FrontBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('date_debut',DateType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('date_fin',DateType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('lieu',TextType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('organisateur',TextType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('description',TextareaType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('nbr_participant',IntegerType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
            ->add('file',FileType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))

            ->add('Valider',SubmitType::class,array( 'attr' => array('class' => 'form-control','required' => true,)))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_evenement';
    }


}
