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
            ->add('quantite')
            ->add('modeleChaussure')
            ->add('tailles', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'taille',
            'mapped'=>false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
