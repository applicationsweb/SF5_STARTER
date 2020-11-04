<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ))
            ->add('nom', TextType::class, array(
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_field_name' => '_token',
        ]);
    }
}
