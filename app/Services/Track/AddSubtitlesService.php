<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Entities\TrackSubtitleEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Track\AddSubtitlesValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class AddSubtitlesService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class AddSubtitlesService extends AbstractApiService
{

    public const MANUAL_TYPE = 'manual';
    public const FILE_TYPE = 'file';
    public const TYPES = [
        self::MANUAL_TYPE,
        self::FILE_TYPE
    ];

    /**
     * @param array             $hashData
     * @param ValidationManager $validationManager
     * @param TrackRepository   $trackRepository
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(array $hashData, ValidationManager $validationManager, TrackRepository $trackRepository): ResponseApiCollectorService
    {

        /** @var SubtitleTypeHandlerService $subtitleTypeHandlerService */
        $subtitleTypeHandlerService = $this->getService('Track\SubtitleTypeHandler');
        $type = $this->request->post()->get('type');
        $inputValidation = $this->inputValidation($validationManager);

        // Input data validation
        if (!$inputValidation->isValidation()) {
            return $this->apiResponse->create(400, $inputValidation->getErrors());
        }

        // Checking the existence of a track
        /** @var TrackEntity|bool $finedTrack */
        if (!$finedTrack = $trackRepository->customFindBy($hashData)->entity()->first()) {
            return $this->createApiResponse(404, 'track@notExist');
        }

        // Calling a subtitle handler of a specific type
        $methodName = sprintf('%sType', $type);
        $subtitles = $subtitleTypeHandlerService->$methodName();

        if ($subtitles instanceof ResponseApiCollectorService) {
            return $subtitles;
        }

        return $this->pushSubtitles($finedTrack, $subtitles);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new AddSubtitlesValidation(), $this->request->post()->all());

    }

    /**
     * @param TrackEntity $trackEntity
     * @param array       $subtitles
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function pushSubtitles(TrackEntity $trackEntity, array $subtitles): ResponseApiCollectorService
    {

        $trackSubtitleEntity = new TrackSubtitleEntity();
        $trackSubtitleEntity
            ->setTrackId($trackEntity->getId())
            ->setSubtitles($subtitles);

        $this->getEntityManager()->commit($trackSubtitleEntity)->flush();

        return $this->createApiResponse(200, 'track@successAddSubtitles');

    }

}