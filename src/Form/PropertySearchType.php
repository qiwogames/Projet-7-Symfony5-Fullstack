<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produit;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class,[
                'label' => 'Catégorie',
                'class' => Categories::class,
                'choice_label' => 'nomCategorie',
                'required' => false,
            ])
            ->add('maxPrix', IntegerType::class,[
                'label' => 'prix maximum',
                'required' => false,
                'attr' => [
                    'placeholer' => '300 €'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
