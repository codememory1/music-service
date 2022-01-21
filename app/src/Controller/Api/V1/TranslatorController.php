<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Service\Translator\Language\CreatorLanguageService;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TranslatorController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class TranslatorController extends AbstractApiController
{

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {

        $this->response = new Response();
        $this->managerRegistry = $managerRegistry;

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return void
     * @throws Exception
     */
    #[Route('/translator/language/create', methods: 'POST')]
    public function createLanguage(Request $request, ValidatorInterface $validator): void
    {

        $creatorLanguageService = new CreatorLanguageService($request, $this->response, $this->managerRegistry);

        $creatorLanguageService->create($validator)->make();

    }

}