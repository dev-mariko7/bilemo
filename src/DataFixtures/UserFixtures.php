<?php


namespace App\DataFixtures;


use App\DataFixtures\services\HandlerImages;
use App\Entity\Customers;
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
        $timezone = new \DateTimeZone('Europe/Paris');
        $time = new \DateTime('now', $timezone);


        for ($i = 1; $i <= self::NUMBER_OF_USERS; $i++)
        {
            $user = new User();
            $currentCustomers = $this->getReference("Customer".rand(1,CustomersFixtures::NUMBER_OF_CUSTOMERS));
            $user->setRoles(["ROLE_USER"]);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user,"pass_" . $i));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setFkCustom($currentCustomers);
            $user->setImage($image->randamImages());
            $user->setDateC($time);

            $manager->persist($user);
            $this->addReference('User'.$i, $user);
        }

        $manager->flush();
    }
}
