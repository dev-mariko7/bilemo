<?php

namespace App\Controller\Handler;

use App\Entity\User;

class HandlerApiAddUser
{
    public function checkUserToAdd(User $userToCreate, $fk_custom, $entityManager)
    {
        $requestStatut = ['errorMessage' => '', 'statut' => true];

        $lastname = $userToCreate->getLastname();
        $firstname = $userToCreate->getFirstname();
        $image = $userToCreate->getImage();
        $statut = $userToCreate->getStatut();

        $check_array = [
            'lasname' => $lastname,
            'firstname' => $firstname,
            'image' => $image,
            'statut' => $statut,
        ];

        $fieldsnotrequired = ['statut', 'statut'];

        foreach ($check_array as $key => $value) {
            if ((empty($value) || '' === $value) && !in_array($key, $fieldsnotrequired)) {
                $errorMessage = 'Le champs '.$key.' est vide';
                $requestStatut['errorMessage'] = $errorMessage;
                $requestStatut['statut'] = false;

                return $requestStatut;
            }
        }

        $user = new User();
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setImage($image);
        $user->setStatut($image);
        $user->setFkCustom($fk_custom);
        $entityManager->persist($user);
        $entityManager->flush();

        return $requestStatut;
    }
}
