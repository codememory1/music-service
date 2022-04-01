<?php

namespace App\Rest\DTO;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractPasswordConfirmationDTO
 *
 * @package App\Rest\DTO
 *
 * @author  Codememory
 */
abstract class AbstractPasswordConfirmationDTO extends AbstractPasswordDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'user@passwordConfirmIsRequired')]
	#[AppAssert\Between('password', message: 'user@invalidPasswordConfirm')]
	public ?string $passwordConfirm = null;

}