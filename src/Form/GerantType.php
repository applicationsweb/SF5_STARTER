<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GerantType extends AbstractType
{
    protected $tokenStorage;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['roles'][0] == 'ROLE_SUPER_ADMIN') {
            $roles = ['Manageur' => 'ROLE_MANAGER', 'Administrateur' => 'ROLE_ADMIN', 'Super Administrateur' => 'ROLE_SUPER_ADMIN'];
        } else if($options['roles'][0] == 'ROLE_ADMIN') {
            $roles = ['Manageur' => 'ROLE_MANAGER', 'Administrateur' => 'ROLE_ADMIN'];
        } else {
            $roles = ['Manageur' => 'ROLE_MANAGER'];
        }
        
        if(!$options['edit']) {
            $builder->add('password', PasswordType::class, array(
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ));
        }

        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => [
                    'class' => 'form-control form-control-sm'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'expanded' => false,
                'multiple' => true,
                'choices' => $roles,
                'attr' => [
                    'class' => 'form-control form-control-sm select2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'roles' => null,
            'edit' => null
        ]);
    }
}
