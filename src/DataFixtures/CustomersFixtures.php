<?php

namespace App\DataFixtures;

use App\Entity\Customers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CustomersFixtures extends Fixture
{
    public const NUMBER_OF_CUSTOMERS = 15;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= self::NUMBER_OF_CUSTOMERS; ++$i) {
            $customer = new Customers();
            $customer->setName($faker->name);
            $customer->setAdress($faker->address);
            $customer->setEmail($faker->email);
            $customer->setPassword($this->encoder->encodePassword($customer, 'pass_'.$i));
            $customer->setRoles(['ROLE_USER']);

            $manager->persist($customer);
            $this->addReference('Customer'.$i, $customer);
        }

        $manager->flush();
    }
}
