<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Mot de passe'
                    ],
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => 8,
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex([
                            'pattern' => "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)^",
                            'match' => true,
                            'message' => "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial !"
                        ])
                    ],
                    'label' => false,
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Répéter le mot de passe'
                    ],
                    'label' => false,
                ],
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
