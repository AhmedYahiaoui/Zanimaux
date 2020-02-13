<?php

namespace FrontBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType2 extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('type',ChoiceType::class, array('choices'  => array(
                'Cosmitique' => 'Cosmitique',
                'Alimentaire' => 'Alimentaire',
                'Accesoires' => 'Accesoires',
            )))

            ->add('nom',TextType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))
            ->add('marque',TextType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))
            ->add('prix',IntegerType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))
            ->add('description',TextareaType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))
            ->add('quantite',IntegerType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))



            ->add('adresseBoutique',ChoiceType::class ,
                array('choices'  => array(
                    'Adresse Boutique 1 ' => 'Adresse Boutique 1 ',
                    'Adresse Boutique 2 ' => 'Adresse Boutique 2 ',
                    'Adresse Boutique 3 ' => 'Adresse Boutique 3 ',
                )))



            ->add('nomBoutique',ChoiceType::class, array('choices'  => array(
                'Boutique 1' => 'Boutique 1',
                'Boutique 2' => 'Boutique 2',
                'Boutique 3' => 'Boutique 3',

            )))

            ->add('numTele',IntegerType::class,array( 'attr' => array('class' => 'form-control input-field','required' => true,)))

            ->add('file')

            ->add('etat',ChoiceType::class, array('choices'  => array(
                'Reserved' => 'Reserved',
                'NotReserved' => 'NotReserved',
            )))


        ;



    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_produit';
    }


}
