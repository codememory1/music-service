<?php

namespace App\DTO\Interceptor;

use App\Rest\DTO\AbstractInterceptor;

/**
 * Class AlbumInputTagsInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class AlbumInputTagsInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): array
	{

		$tags = explode(',', $requestKey);

		return array_map(function(string|int $value) {
			return trim($value);
		}, $tags);

	}

}