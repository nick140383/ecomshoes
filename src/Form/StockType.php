<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Taille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite', null, [
                'required'   => true,
                'mapped'=>true,
                'empty_data'=>true,
            ])
            ->add('modeleChaussure')
            ->add('taille', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'taille',
                'required' => false,
                //'empty_data'=>true,
                'multiple' => false,
               // 'expanded' => true,
           // 'data_class'=>null,
            'mapped'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
