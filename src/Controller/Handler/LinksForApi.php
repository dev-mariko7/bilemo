<?php

namespace App\Controller\Handler;

use App\Entity\Products;
use App\Entity\User;

class LinksForApi
{
    private array $links_users;
    private array $links_products;

    public function setProductsLinks($objet)
    {
        $objets = $objet;

        if ($objet instanceof Products) {
            $objets = [];
            $objets[] = $objet;
        }

        foreach ($objets as $obj) {
            $self = '/products/'.$obj->getId();
            $modify = '';
            $add = '';
            $delete = '';

            if (empty($this->links_products)) {
                $links = [
                'self' => [
                    'href' => $self,
                ],
            ];

                if (!empty($modify)) {
                    $links['modify'] = ['href' => $modify];
                }
                if (!empty($add)) {
                    $links['add'] = ['href' => $add];
                }
                if (!empty($delete)) {
                    $links['delete'] = ['href' => $delete];
                }
            }

            $obj->setLinks($links);
        }
    }

    public function setUsersLinks($objet)
    {
        $objets = $objet;

        if ($objet instanceof User) {
            $objets = [];
            $objets[] = $objet;
        }

        foreach ($objets as $obj) {
            $self = '/users/'.$obj->getId();
            $getby = '';
            $modify = '';
            $add = '/users/';
            $delete = '/users/'.$obj->getId();

            if (empty($this->links_users)) {
                $links = [
                'self' => [
                    'href' => $self,
                ],
            ];

                if (!empty($modify)) {
                    $links['modify'] = ['href' => $modify];
                }
                if (!empty($add)) {
                    $links['add'] = ['href' => $add];
                }
                if (!empty($delete)) {
                    $links['delete'] = ['href' => $delete];
                }
            }

            $obj->setLinks($links);
        }
    }
}
