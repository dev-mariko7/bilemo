<?php

namespace App\Controller\Handler;

use App\Entity\User;

class HandlerApiAddUser
{
    public function checkUserToAdd(User $userToCreate, $fk_custom)
    {
        $requestStatut = ['errorMessage' => '', 'statut' => true];
        $lastname = json_decode($userToCreate->getContent())->lastname;
        $firstname = json_decode($userToCreate->getContent())->firstname;
        $image = json_decode($userToCreate->getContent())->image;
        $statut = json_decode($userToCreate->getContent())->statut;

        $check_array = [
            'lasname' => $lastname,
            'firstname' => $firstname,
            'image' => $image,
            'statut' => $statut,
        ];

        foreach ($check_array as $key => $value) {
            if (empty($value) && 'image' !== $key) {
                $errorMessage = 'Le champs'.$key.'Est vide';
                $requestStatut['errorMessage'] = $errorMessage;
                $requestStatut['statut'] = false;

                return $requestStatut;
            }
        }

        $user = new User();
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setImage($image);
        $user->setFkCustom($fk_custom);

        return $requestStatut;
    }
}
