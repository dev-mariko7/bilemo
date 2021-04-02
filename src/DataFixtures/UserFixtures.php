<?php

namespace App\DataFixtures;

use App\DataFixtures\services\HandlerImages;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    const NUMBER_OF_USERS = 10;
    private $kernel;

    public function __construct(UserPasswordEncoderInterface $encoder, KernelInterface $kernel)
    {
        $this->encoder = $encoder;
        $this->kernel = $kernel;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $image = new HandlerImages($this->kernel);


        for ($i = 1; $i <= self::NUMBER_OF_USERS; ++$i) {
            $user = new User();
            $currentCustomers = $this->getReference('Customer'.rand(1, CustomersFixtures::NUMBER_OF_CUSTOMERS));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setFkCustom($currentCustomers);
            $user->setImage($image->randamImages());


            $manager->persist($user);
            $this->addReference('User'.$i, $user);
        }

        $manager->flush();
    }
}
