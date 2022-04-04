<?php

namespace App\Security\ConfirmationRegistration;

use App\Entity\UserActivationToken;
use App\Security\AbstractSecurity;

/**
 * Class DeleterToken.
 *
 * @package App\Security\ConfirmationRegistration
 *
 * @author  Codememory
 */
class DeleterToken extends AbstractSecurity
{
    /**
     * @param UserActivationToken $userActivationToken
     *
     * @return UserActivationToken
     */
    public function delete(UserActivationToken $userActivationToken): UserActivationToken
    {
        $this->em->remove($userActivationToken);
        $this->em->flush();

        return $userActivationToken;
    }
}