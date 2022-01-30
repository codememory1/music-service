<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Enums\ApiResponseTypeEnum;
use App\Repository\TranslationKeyRepository;
use App\Service\AbstractApiService;
use App\Service\Response\ApiResponseService;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UpdaterTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class UpdaterTranslationKeyService extends AbstractApiService
{

    /**
     * @param int                $id
     * @param ValidatorInterface $validator
     * @param callable           $handler
     *
     * @return ApiResponseService
     * @throws Exception
     */
    public function update(int $id, ValidatorInterface $validator, callable $handler): ApiResponseService
    {

        /** @var TranslationKeyRepository $translationKeyRepository */
        $translationKeyRepository = $this->em->getRepository(TranslationKey::class);

        // Check exist translation key
        if (null === $finedTranslationKey = $translationKeyRepository->findOneBy(['id' => $id])) {
            $this
                ->prepareApiResponse('error', 404)
                ->setMessage(
                    ApiResponseTypeEnum::CHECK_EXIST,
                    'translation_key_not_exist',
                    $this->getTranslation('translationKey@notExist')
                );

            return $this->getPreparedApiResponse();
        }

        $translationKeyEntity = $this->collectEntity($finedTranslationKey);

        // Input validation
        if (true !== $resultInputValidation = $this->inputValidation($translationKeyEntity, $validator)) {
            return $resultInputValidation;
        }

        // Calling an Extender Method
        return call_user_func($handler, $translationKeyEntity);

    }

    /**
     * @param TranslationKey $translationKeyEntity
     *
     * @return TranslationKey
     */
    private function collectEntity(TranslationKey $translationKeyEntity): TranslationKey
    {

        $translationKeyEntity->setName($this->request->get('name'));

        return $translationKeyEntity;

    }

}