<?php

namespace App\Service;

/**
 * Class HashingService
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class HashingService
{

	/**
	 * @param string $password
	 *
	 * @return string
	 */
	final public function encode(string $password): string
	{

		return password_hash(hash('sha256', $password), PASSWORD_ARGON2ID, ['cost' => 10]);

	}

	/**
	 * @param string $password
	 * @param string $hash
	 *
	 * @return bool
	 */
	final public function compare(string $password, string $hash): bool
	{

		return password_verify(hash('sha256', $password), $hash);

	}

}