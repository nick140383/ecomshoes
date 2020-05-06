<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\ModeleChaussure;
use App\Entity\Taille;
use App\Form\PhotoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleChaussureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prix',MoneyType::class)
            ->add('description', TextareaType::class)
           // ->add('coverImage',UrlType::class)
            ->add('tailles', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'taille',
                'multiple' => true
            ])
            ->add('marque',EntityType::class,[
                'class'=>Marque::class,
                'choice_label'=>'nom'
            ])
           ->add(
                'photos',
                CollectionType::class, [
                    'entry_type' => PhotoType::class,
                    'allow_add'=>true,
                    'prototype' => true,
                    'by_reference' => false,


                ])

            ->add('coverImage',FileType::class,array('label'=>'importez une image de couverture'


            ))
            ->add('Ajouter une nouvelle chaussure',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-success'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModeleChaussure::class,
        ]);
    }
}