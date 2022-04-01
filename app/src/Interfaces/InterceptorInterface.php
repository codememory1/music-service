<?php

namespace App\Interfaces;

/**
 * Interface InterceptorInterface
 *
 * @package  App\Interfaces
 *
 * @author   Codememory
 */
interface InterceptorInterface
{

	/**
	 * @param string $requestKey
	 * @param mixed  $requestValue
	 *
	 * @return mixed
	 */
	public function process(string $requestKey, mixed $requestValue): mixed;

}