<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\ModeleChaussure;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire',TextareaType::class,$this->getConfiguration("votre avis","N'hesitez pas à être precis ,celà aidera nos potentiels clients"))
            ->add('rating',IntegerType::class,$this->getConfiguration("note sur5","Veuillez indiquer votre note de 0 à 5",[
                'attr'=>[
                    'min'=>0,
                    'max'=>5,
                    'step'=>1
                ]
            ]))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
