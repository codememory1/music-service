<?php

namespace App\DTO;

use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AuthorizationDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AuthorizationDTO extends AbstractDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'user@loginIsRequired')]
	public ?string $login = null;

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'user@passwordIsRequired')]
	public ?string $password = null;

	/**
	 * @var string|null
	 */
	public ?string $clientIp = null;

	/**
	 * @return void
	 */
	protected function wrapper(): void
	{

		$this
			->addExpectedRequestKey('login')
			->addExpectedRequestKey('password');

		$this->clientIp = $this->request->request->getClientIp();

	}

}