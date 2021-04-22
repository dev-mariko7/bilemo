<?php

namespace App\DataFixtures;

use App\DataFixtures\services\HandlerImages;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\HttpKernel\KernelInterface;

class ProductsFixtures extends Fixture
{
    const NUMBER_OF_PRODUCTS = 50;
    private $dirroot;
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->dirroot = $kernel->getProjectDir().'/public/images';
        $this->kernel = $kernel;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $timezone = new \DateTimeZone('Europe/Paris');
        $time = new \DateTime('now', $timezone);
        $image = new HandlerImages($this->kernel);

        for ($i = 1; $i <= self::NUMBER_OF_PRODUCTS; ++$i) {
            $product = new Products();
            $product->setDescription($faker->text);
            $product->setCover($image->randamImages());
            $product->setName($faker->name);
            $product->setPrice((string) rand(0, 1000));
            $product->setProductType('type'.$i);
            $product->setDateC($time);
            $product->setDateM($time);
            $product->setQuantity(rand(0, 150));

            $manager->persist($product);
            $this->addReference('Product '.$i, $product);
        }

        $manager->flush();
    }
}
