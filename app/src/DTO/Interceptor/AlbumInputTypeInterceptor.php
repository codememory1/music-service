<?php

namespace App\DTO\Interceptor;

use App\Entity\AlbumType;
use App\Repository\AlbumTypeRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class AlbumInputTypeInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class AlbumInputTypeInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): ?AlbumType
	{

		/** @var AlbumTypeRepository $albumTypeRepository */
		$albumTypeRepository = $this->context->em->getRepository(AlbumType::class);

		return $albumTypeRepository->find($requestValue);

	}

}