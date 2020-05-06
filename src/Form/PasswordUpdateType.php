<?php

namespace App\Form;

use App\Form\ApplicationType;
use App\Entity\PasswordUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class, $this->getConfiguration("ancien mot de passe","Donnez votre nouveau mot de passe actuel..."))
            ->add('newPassword',PasswordType::class, $this->getConfiguration("Nouveau mot de Passe","Tapez votre nouveau mot de passe..."))
            ->add('confirmPassword',Passwordtype::class, $this->getConfiguration("confirmation du nouveau mot de passe","Confirmez votre nouveau mot de passe..."));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }


}
