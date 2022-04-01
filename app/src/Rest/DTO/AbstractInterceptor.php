<?php

namespace App\Rest\DTO;

use App\Interfaces\InterceptorInterface;

/**
 * Class AbstractInterceptor
 *
 * @package App\Rest\DTO
 *
 * @author  Codememory
 */
abstract class AbstractInterceptor implements InterceptorInterface
{

	/**
	 * @var AbstractDTO
	 */
	protected readonly AbstractDTO $context;

	/**
	 * @param AbstractDTO $context
	 */
	public function __construct(AbstractDTO $context)
	{

		$this->context = $context;

	}

}