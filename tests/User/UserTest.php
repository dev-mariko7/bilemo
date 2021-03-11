<?php

namespace App\Tests\User;

use App\Entity\Customers;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    public function testAddUser()
    {
        $user = new User();
        $customers = new Customers();
        $user->setLastname('LeFrançais');
        $user->setFirstname('Toto');
        $user->setImage('/image.jpg');
        $user->setFkCustom($customers);

        $this->assertSame('LeFrançais', $user->getLastname());
        $this->assertSame('Toto', $user->getFirstname());
        $this->assertSame('/image.jpg', $user->getImage());
        $this->assertInstanceOf(Customers::class, $user->getFkCustom());
    }
}
