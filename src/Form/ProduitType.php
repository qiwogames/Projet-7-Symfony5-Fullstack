<?php

namespace App\Form;

use App\Entity\Distributeur;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProduit', TextType::class,[
                'label' => 'Nom du produit :',
                'attr' =>[
                    'placeholder' => 'ex: Table basse',
                    'class' => 'mt-3 mb-3'
                ]
            ])
            ->add('prixProduit', NumberType::class,[
                'label' => 'Prix du produit en € :',
                'attr' => [
                    'placeholder' => 'ex: 124.25 ',
                    'class' => 'mt-3 mb-3'
                ]
            ])
            ->add('quantiteProduit', NumberType::class, [
                'label' => 'Quantité en stock :',
                'attr' => [
                    'placeholder' => "ex: 250",
                    'class' => 'mt-3 mb-3'
                ]
            ])

            ->add('photoProduit', FileType::class,[
                'label' => 'Image du produit :',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'Aucune image',
                'attr' => [
                    'class' => 'form-control mt-3 mb-3'
                ]
            ])
            ->add('rupture', CheckboxType::class,[
                'label' => 'En stock ?',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ]
            ])

            ->add('reference', ReferenceType::class,[
                'required' => false
            ])
            ->add('ajouter_distributeurs', CollectionType::class,[
                'entry_type' => DistributeurType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('distributeurs', EntityType::class,[
                'class' => Distributeur::class,
                'choice_label' => 'nomDistributeur',
                'label' => 'Selectionnez un ou plusieurs distributeur(s)',
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
