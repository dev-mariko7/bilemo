<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    const NUMBER_OF_USERS = 10;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= self::NUMBER_OF_USERS; $i++)
        {
            $user = new User();
            $user->setRoles(["ROLE_USER"]);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user,"pass_" . $i));

            $manager->persist($user);
            $this->addReference('User'.$i, $user);
        }

        $manager->flush();
    }
}
