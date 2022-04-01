<?php

namespace App\DTO\Interceptor;

use App\Entity\TranslationKey;
use App\Repository\TranslationKeyRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class TranslationInputTranslationKeyInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class TranslationInputTranslationKeyInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): ?TranslationKey
	{

		/** @var TranslationKeyRepository $translationKeyRepository */
		$translationKeyRepository = $this->context->em->getRepository(TranslationKey::class);

		return $translationKeyRepository->findOneBy(['name' => $requestValue]);

	}

}