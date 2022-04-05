<?php

namespace App\Security\PasswordReset;

use App\Rest\Http\Response;
use App\Security\AbstractSecurity;

/**
 * Class RecoveryRequest.
 *
 * @package App\Security\PasswordReset
 *
 * @author  Codememory
 */
class RecoveryRequest extends AbstractSecurity
{
    /**
     * @return Response
     */
    public function successRecoveryRequest(): Response
    {
        return $this->responseCollection
            ->successRecoveryRequest('passwordReset@successRecoveryRequest')
            ->getResponse();
    }
}