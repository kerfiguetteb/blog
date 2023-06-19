<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;


class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $manager;
    private $faker;

    public static function getGroups(): array
    {
        return ['test'];
    }
    
    public function __construct(
    ManagerRegistry $doctrine,
    UserPasswordHasherInterface $passwordHasher
    
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = FakerFactory::create('fr_FR');
        // $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadUser();
        $this->loadPost();
    }

    public function loadUser() :void
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setNom('outman');
        $user->setPrenom('kerfi');
        $plaintextPassword = '123';
        $password = $this->passwordHasher->hashPassword($user,$plaintextPassword);
        $user->setPassword($password);
        // Le format de la chaîne de caractères ROLE_FOO_BAR_BAZ
        // est libre mais il vaut mieux suivre la convention
        // proposée par Symfony.
        $user->setRoles(['ROLE_ADMIN']);

        // Demande d'enregistrement d'un objet dans la BDD.
        $this->manager->persist($user);
        $this->manager->flush();

        for ($i=0; $i < 20; $i++) { 
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setNom($this->faker->lastName());
            $user->setPrenom($this->faker->firstName());
            $plaintextPassword = '123';
            $password = $this->passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($password);
            // Le format de la chaîne de caractères ROLE_FOO_BAR_BAZ
            // est libre mais il vaut mieux suivre la convention
            // proposée par Symfony.
            $user->setRoles(['ROLE_ADMIN']);
    
            // Demande d'enregistrement d'un objet dans la BDD.
            $this->manager->persist($user);
            $this->manager->flush();
    
        }

    }

    public function loadPost(){

        $repository = $this->manager->getRepository(User::class);
        $users = $repository->findAll();


        for ($i = 0; $i < 100; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->word())
                ->setIntroduction("Lorem Ipsum is simply dummy text of the") 
                ->setContent("Lorem Ipsum is simply dummy text of 
                the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently 
                with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum")
                ->setUser($users[random_int(0,count($users)-1)])
                ->setVisibilite(true);


            $this->manager->persist($post);
        }

        $this->manager->flush();
    }
}
