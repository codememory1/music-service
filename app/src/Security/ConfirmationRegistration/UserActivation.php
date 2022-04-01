<?php

namespace App\Security\ConfirmationRegistration;

use App\Entity\UserActivationToken;
use App\Rest\Http\Response;

/**
 * Class UserActivation
 *
 * @package App\Security\ConfirmationRegistration
 *
 * @author  Codememory
 */
class UserActivation
{

	public function activate(): Response {}

	public function existToken(string $token): UserActivationToken|bool {}

	public function isValid(): Response {}

}