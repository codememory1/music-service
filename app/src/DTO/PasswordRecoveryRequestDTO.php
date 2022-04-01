<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PasswordRecoveryRequestDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class PasswordRecoveryRequestDTO extends AbstractDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'recoveryRequest@emailIsRequired')]
	#[Assert\Email(message: 'common@invalidEmail')]
	public ?string $email = null;

	/**
	 * @return void
	 */
	protected function wrapper(): void
	{

		$this->addExpectedRequestKey('email');

	}

}