<?php

namespace App\Security;

use App\Entity\Customers;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW_USER = 'view';
    const DELETE_USER = 'delete';

    public function __construct()
    {
    }

    protected function supports(string $attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW_USER])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $customers = $token->getUser();

        if (!$customers instanceof Customers) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var User $post */
        $user = $subject;

        switch ($attribute) {
            case self::VIEW_USER:
                return $this->canViewUser($user, $customers);
            case self::DELETE_USER:
                return $this->canDeleteUser($user, $customers);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canViewUser(User $user, Customers $customers)
    {
        // this assumes that the Post object has a `getOwner()` method
        return $customers === $user->getFkCustom();
    }

    private function canDeleteUser(User $user, Customers $customers, EntityManagerInterface $entityManager)
    {
        if ($customers === $user->getFkCustom()) {
            $entityManager->remove($user);
            if ($entityManager->flush()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
