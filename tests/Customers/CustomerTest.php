<?php

namespace App\Tests\Customers;

use App\Entity\Customers;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerTest extends WebTestCase
{
    public function testAddCustomer()
    {
        $customer = new Customers();
        $customer->setName('TestName enterprise');
        $customer->setAdress('5 avenue du general sankara');
        $customer->setPassword('test');
        $customer->setRoles(['ROLE_USER']);
        $customer->setEmail('test@test.fr');

        $this->assertSame('test@test.fr', $customer->getEmail());
        $this->assertSame('test', $customer->getPassword());
        $this->assertSame(['ROLE_USER'], $customer->getRoles());
        $this->assertSame('TestName enterprise', $customer->getName());
        $this->assertSame('5 avenue du general sankara', $customer->getAdress());
    }
}
