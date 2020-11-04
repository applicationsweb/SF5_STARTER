<?php

namespace App\Form;

use App\Entity\PasswordUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Mot de passe actuel',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ],
            ))
            ->add('newPassword', PasswordType::class, array(
                'label' => 'Nouveau mot de passe',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ],
            ))
            ->add('confirmPassword', PasswordType::class, array(
                'label' => 'Confirmation de mot de passe',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PasswordUpdate::class,
            'csrf_field_name' => '_token',
        ]);
    }
}
