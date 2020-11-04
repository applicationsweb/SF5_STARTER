<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Nom d\'utilisateur'
                ]
            ))
            ->add('prenom', TextType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Prénom'
                ]
            ))
            ->add('nom', TextType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Nom'
                ]
            ))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Adresse e-mail'
                ]
            ))
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'J\'accepte les conditions d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci d\'accepter les conditions d\'utilisation',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Mot de passe'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
