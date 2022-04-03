<?php

namespace App\Rest;

use App\Interfaces\DTOInterface;
use App\Interfaces\EntityInterface;
use App\Rest\Http\ResponseCollection;
use App\Rest\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ApiService.
 *
 * @package App\Rest
 *
 * @author  Codememory
 */
class ApiService
{

    /**
     * @var EntityManagerInterface
     */
    protected readonly EntityManagerInterface $em;

    /**
     * @var ApiManager
     */
    protected readonly ApiManager $manager;

    /**
     * @var Translator
     */
    protected readonly Translator $translator;

    /**
     * @var ResponseCollection
     */
    protected readonly ResponseCollection $responseCollection;

    /**
     * @var Validator
     */
    protected readonly Validator $validator;

    /**
     * @param ApiManager        $apiManager
     * @param Translator        $translator
     * @param ResponseCollection $responseCollection
     * @param Validator         $validator
     */
    public function __construct(
        ApiManager $apiManager,
        Translator $translator,
        ResponseCollection $responseCollection,
        Validator $validator
    ) {
        $this->em = $apiManager->em;
        $this->manager = $apiManager;
        $this->translator = $translator;
        $this->responseCollection = $responseCollection;
        $this->validator = $validator;
    }

    /**
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    protected function getTranslation(string $key, string $default = ''): string
    {
        return $this->translator->getTranslation($key, $default);
    }

    /**
     * @param DTOInterface|EntityInterface $entityOrDTO
     *
     * @return Validator
     */
    public function inputValidation(EntityInterface|DTOInterface $entityOrDTO): Validator
    {
        $this->validator->validate($entityOrDTO);

        return $this->validator;
    }
}