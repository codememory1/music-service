<?php

namespace App\DTO\Interceptor;

use App\Entity\Language;
use App\Repository\LanguageRepository;
use App\Rest\DTO\AbstractInterceptor;

/**
 * Class TranslationInputLanguageInterceptor
 *
 * @package App\DTO\Interceptor
 *
 * @author  Codememory
 */
class TranslationInputLanguageInterceptor extends AbstractInterceptor
{

	/**
	 * @inheritDoc
	 */
	public function process(string $requestKey, mixed $requestValue): ?Language
	{

		/** @var LanguageRepository $languageRepository */
		$languageRepository = $this->context->em->getRepository(Language::class);

		return $languageRepository->findOneBy(['code' => $requestValue]);

	}

}