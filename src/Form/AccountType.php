<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'H',
                    'Femme' => 'F'],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('adresse')
            ->add('email')
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
