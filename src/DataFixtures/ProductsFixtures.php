<?php


namespace App\DataFixtures;


use App\Entity\Products;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

class ProductsFixtures extends Fixture
{

    Const NUMBER_OF_PRODUCTS = 50;
    private $dirroot;

    public function __construct(KernelInterface $kernel)
    {
        $this->dirroot = $kernel->getProjectDir()."/public/images";
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $finder = new Finder();
        $timezone = new \DateTimeZone('Europe/Paris');
        $time = new \DateTime('now', $timezone);

        $getpictures = $finder->files()->in($this->dirroot);

        foreach ($getpictures as $file)
        {
            $pictures[] = $file->getRelativePathname();
        }

        for ($i = 1; $i <= self::NUMBER_OF_PRODUCTS; $i++)
        {
            $product = new Products();
            $product->setDescription($faker->text);
            $product->setCover($pictures[rand(0,count($pictures)-1)]);
            $product->setName($faker->name);
            $product->setPrice((string)rand(0,1000));
            $product->setProductType("type" . $i);
            $product->setDateC($time);
            $product->setDateM($time);
            $product->setQuantity(rand(0,150));

            $manager->persist($product );
            $this->addReference('Product '.$i, $product );
        }

        $manager->flush();
    }
}
