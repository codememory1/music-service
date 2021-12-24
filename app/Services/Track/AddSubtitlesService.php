<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Entities\TrackSubtitleEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractCrudService;
use App\Services\ResponseApiCollectorService;
use App\Validations\Track\AddSubtitlesValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Components\Validator\Manager as ValidationManager;
use ReflectionException;

/**
 * Class AddSubtitlesService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class AddSubtitlesService extends AbstractCrudService
{

    public const MANUAL_TYPE = 'manual';
    public const FILE_TYPE = 'file';
    public const TYPES = [
        self::MANUAL_TYPE,
        self::FILE_TYPE
    ];

    /**
     * @param ValidationManager $manager
     * @param TrackRepository   $trackRepository
     * @param array             $hashData
     *
     * @return AddSubtitlesService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    public function make(Manager $manager, TrackRepository $trackRepository, array $hashData): static
    {

        $validatedDataManager = $this->makeInputValidation($manager, new AddSubtitlesValidation());
        $type = $this->request->post()->get('type');

        // Input data validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking the existence of a track
        /** @var TrackEntity|bool $finedTrack */
        if (!$finedTrack = $trackRepository->customFindBy($hashData)->entity()->first()) {
            return $this->setResponse(
                $this->createApiResponse(404, 'track@notExist')
            );
        }

        // Calling a subtitle handler of a specific type
        $typeHandler = $this->typeHandlerInvocation($type);

        if ($typeHandler instanceof ResponseApiCollectorService) {
            return $this->setResponse($typeHandler);
        }

        // Push subtitles into the database
        return $this->push($finedTrack, $typeHandler);

    }

    /**
     * @param string $type
     *
     * @return ResponseApiCollectorService|array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function typeHandlerInvocation(string $type): ResponseApiCollectorService|array
    {

        /** @var SubtitleTypeHandlerService $subtitleTypeHandlerService */
        $subtitleTypeHandlerService = $this->getService('Track\SubtitleTypeHandler');

        $methodName = sprintf('%sType', $type);

        return $subtitleTypeHandlerService->$methodName();

    }

    /**
     * @param TrackEntity $trackEntity
     * @param array       $subtitles
     *
     * @return AddSubtitlesService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function push(TrackEntity $trackEntity, array $subtitles): static
    {

        $trackSubtitleEntity = new TrackSubtitleEntity();
        $trackSubtitleEntity
            ->setTrackId($trackEntity->getId())
            ->setSubtitles($subtitles);

        $this->getEntityManager()
            ->commit($trackSubtitleEntity)
            ->flush();

        $this->setResponse(
            $this->createApiResponse(200, 'track@successAddSubtitles')
        );

        return $this;

    }

}