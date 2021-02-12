<?php

namespace App\Tests\Products;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testAddProduct()
    {
        $timezone = new \DateTimeZone('Europe/Paris');
        $time = new \DateTime('now', $timezone);

        $product = new Products();
        $product->setName('Iphone12');
        $product->setDescription('Le dernier telephone tendance');
        $product->setCover('testimage.jpg');
        $product->setPrice('10.99');
        $product->setQuantity(12);
        $product->setDateC($time);
        $product->setDateM($time);

        $this->assertSame('Iphone12', $product->getName());
        $this->assertSame('Le dernier telephone tendance', $product->getDescription());
        $this->assertSame('testimage.jpg', $product->getCover());
        $this->assertSame('10.99', $product->getPrice());
        $this->assertSame(12, $product->getQuantity());
        $this->assertSame($time, $product->getDateC());
        $this->assertSame($time, $product->getDateM());
    }
}
