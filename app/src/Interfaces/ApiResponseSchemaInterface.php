<?php

namespace App\Interfaces;

use App\Enum\ApiResponseTypeEnum;

/**
 * Interfaces ApiResponseSchemaInterface
 *
 * @package App\Interfaces
 *
 * @author  Codememory
 */
interface ApiResponseSchemaInterface
{

	/**
	 * @param ApiResponseTypeEnum $type
	 * @param string              $text
	 *
	 * @return ApiResponseSchemaInterface
	 */
	public function setMessage(ApiResponseTypeEnum $type, string $text): ApiResponseSchemaInterface;

	/**
	 * @param array $data
	 *
	 * @return ApiResponseSchemaInterface
	 */
	public function setData(array $data): ApiResponseSchemaInterface;

}