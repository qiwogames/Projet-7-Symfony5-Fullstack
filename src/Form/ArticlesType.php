<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\CategoriesArticles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomArticle', TextType::class)
            ->add('contenuArticle', TextareaType::class)
            ->add('imageArticle', FileType::class,[
                'required' => false,
                'data_class' => null,
                'empty_data' => 'Aucune image pour cet article',

            ])
            ->add('auteurArticle', TextType::class)
            ->add('dateArticle', DateTimeType::class)
            ->add('categoriesArticles', EntityType::class,[
                'class' => CategoriesArticles::class,
                'choice_label' => 'nomCategorie',
                'label' => 'Catégorie de l\'article',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
