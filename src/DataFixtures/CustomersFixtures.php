<?php


namespace App\DataFixtures;


use App\Entity\Customers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CustomersFixtures extends Fixture
{
    public Const NUMBER_OF_CUSTOMERS = 15;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= self::NUMBER_OF_CUSTOMERS; $i++)
        {
            $customer = new Customers();
            $customer->setName($faker->name);
            $customer->setAdress($faker->address);

            $manager->persist($customer);
            $this->addReference('Customer'.$i, $customer);
        }

        $manager->flush();
    }
}
