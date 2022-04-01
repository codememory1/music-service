<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;

/**
 * Class MediaLibraryMusicInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class MediaLibraryMusicInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): mixed
	{

		$decodedValue = json_decode($requestValue, true);

		if (json_last_error() === JSON_ERROR_NONE) {
			return $decodedValue;
		}

		if (is_array($requestValue)) {
			return $requestValue;
		}

		return [];

	}

}