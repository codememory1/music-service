<?php

namespace App\Service\Translator\Language;

use App\Entity\Language;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\LanguageRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class UpdaterLanguageService extends AbstractApiService
{

    /**
     * @param int                $id
     * @param ValidatorInterface $validator
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(int $id, ValidatorInterface $validator): ApiResponseService
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->em->getRepository(Language::class);

        // Check exist language
        if (null === $finedLanguage = $languageRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'lang_not_exist',
                    $this->getTranslation('lang@langNotExist')
                );

            return $this->getPreparedApiResponse();
        }

        $languageEntity = $this->collectEntity($finedLanguage);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($languageEntity, $validator)) {
            return $resultInputValidation;
        }

        // Update found record
        return $this->push($languageEntity, 'lang@successUpdate', true);

    }

    /**
     * @param Language|null $defaultEntity
     *
     * @return Language
     */
    private function collectEntity(?Language $defaultEntity = null): Language
    {

        $languageEntity = $defaultEntity ?? new Language();

        $languageEntity
            ->setCode($this->request->get('code', ''))
            ->setTitle($this->request->get('title', ''));

        return $languageEntity;

    }

}