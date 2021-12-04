<?php

namespace App\Services\Translation;

use App\Orm\Entities\LanguageEntity;
use App\Orm\Repositories\LanguageRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Translation\CreateLanguageValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use Codememory\Support\Str;
use ReflectionException;

/**
 * Class CreatorLanguageService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class CreatorLanguageService extends AbstractApiService
{

    /**
     * @param ValidationManager $validationManager
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function create(ValidationManager $validationManager): ResponseApiCollectorService
    {

        $languageCode = Str::toLowercase($this->request->post()->get('lang') ?: '');
        $creationValidationManager = $this->inputValidation($validationManager);

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->getRepository(LanguageEntity::class);

        // Input validation
        if (!$creationValidationManager->isValidation()) {
            return $this->apiResponse->create(400, $creationValidationManager->getErrors());
        }

        // Checking for the existence of a language
        if ($languageRepository->getLang($languageCode)) {
            return $this->createApiResponse(400, 'translation@langExist');
        }

        return $this->pushLanguage($languageCode);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new CreateLanguageValidation(), $this->request->post()->all());

    }

    /**
     * @param string $languageCode
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function pushLanguage(string $languageCode): ResponseApiCollectorService
    {

        $languageEntity = new LanguageEntity();

        $languageEntity->setLang($languageCode);

        $this->getEntityManager()->commit($languageEntity)->flush();

        return $this->createApiResponse(200, 'translation@successCreateLang');

    }

}