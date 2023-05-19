<?php

namespace App\Controller;

use App\DTO\Closed\UpdatePreferenceDTO;
use App\Repository\PreferenceRepository;
use App\UseCase\Closed\UpdatePreferences;
use Codememory\ApiBundle\Decorator\ControllerEntityArgument\EntityNotFound;
use App\Entity\Preference;
use App\Exceptions\EntityNotFoundException;
use App\ResponseControl\Open\PreferenceResponseControl as OpenPreferenceResponseControl;
use App\ResponseControl\Closed\PreferenceResponseControl as ClosedPreferenceResponseControl;
use Codememory\ApiBundle\Controller\AbstractController;
use Codememory\ApiBundle\Exceptions\HttpException;
use Codememory\ApiBundle\ResponseSchema\Interfaces\ResponseSchemaInterface;
use Codememory\ApiBundle\ResponseSchema\View\MessageView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/preferences')]
final class PreferenceController extends AbstractController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(ClosedPreferenceResponseControl $responseControl, PreferenceRepository $preferenceRepository): ResponseSchemaInterface
    {
        return $this->responseControl(200, $responseControl->setData($preferenceRepository->findAll()));
    }

    #[Route('/{preference_key<[A-Z_]+>}/read', methods: Request::METHOD_GET)]
    public function performer(
        #[EntityNotFound(EntityNotFoundException::class, 'preference')] Preference $preference,
        OpenPreferenceResponseControl $responseControl
    ): ResponseSchemaInterface
    {
        return $this->responseControl(200, $responseControl->setData($preference));
    }

    /**
     * @throws HttpException
     */
    #[Route('/edit', methods: Request::METHOD_PUT)]
    public function edit(UpdatePreferenceDTO $dto, UpdatePreferences $updatePreferences): ResponseSchemaInterface
    {
        $this->prepareDTO($dto);

        $updatePreferences->process($dto);

        return $this->response(200, new MessageView('entity.app.preferences.success_edit'));
    }
}