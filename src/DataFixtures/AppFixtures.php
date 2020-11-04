<?php

namespace App\DataFixtures;
use Faker\Factory;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder; 
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $factory = new Factory();
        $faker = $factory->create('fr_FR');

        // Créer un super-admin
        $user = new User();
        $password = $this->encoder->encodePassword($user, 'Superadmin,123456');
        $user->setUsername('romainJrds')
            ->setEmail('contact@applicationsweb.fr')
            ->setPassword($password)
            ->setPrenom('Romain')
            ->setNom('Jrds')
            ->setIsVerified(1)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        // Créer un second super-admin
        $user = new User();
        $password = $this->encoder->encodePassword($user, 'Superadmin,123456');
        $user->setUsername('admin')
            ->setEmail('monemail@gmail.com')
            ->setPassword($password)
            ->setPrenom('Thomas')
            ->setNom('Dupuis')
            ->setIsVerified(1)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        // Créer entre 10 et 30 administrateurs
        $rand = mt_rand(10, 30);
        for($i = 0; $i < $rand; $i++) {
            $admin = new User();
            $password = $this->encoder->encodePassword($user, 'Admin,123456');
            $admin->setUsername($faker->lastName.strval(mt_rand(1,9)).strval(mt_rand(1,9)))
                ->setEmail($faker->email)
                ->setPassword($password)
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setIsVerified(1)
                ->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
        }

        // Créer entre 10 et 30 manageurs
        for($i = 0; $i < $rand; $i++) {
            $admin = new User();
            $password = $this->encoder->encodePassword($user, 'Manageur,123456');
            $admin->setUsername($faker->lastName.strval(mt_rand(1,9)).strval(mt_rand(1,9)))
                ->setEmail($faker->email)
                ->setPassword($password)
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setIsVerified(1)
                ->setRoles(['ROLE_MANAGER']);
            $manager->persist($admin);
        }

        // Créer entre 10 et 30 utilisateurs
        for($i = 0; $i < $rand; $i++) {
            $admin = new User();
            $password = $this->encoder->encodePassword($user, 'User,123456');
            $admin->setUsername($faker->lastName.strval(mt_rand(1,9)).strval(mt_rand(1,9)))
                ->setEmail($faker->email)
                ->setPassword($password)
                ->setPrenom($faker->firstName)
                ->setNom($faker->lastName)
                ->setIsVerified(1)
                ->setRoles(['ROLE_USER']);
            $manager->persist($admin);
        }

        $manager->flush();
    }
}
