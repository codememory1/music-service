<?php

namespace App\Services\Track;

use App\Orm\Entities\AlbumEntity;
use App\Orm\Entities\TrackCategoryEntity;
use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\AlbumRepository;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractCrudService;
use App\Services\FileLoaderService;
use App\Services\ResponseApiCollectorService;
use App\Services\Translation\DataService;
use App\Validations\Track\AddTrackValidation;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\Pack\DatabasePack;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Manager;
use Codememory\Container\ServiceProvider\Interfaces\ServiceProviderInterface;
use Codememory\HttpFoundation\Interfaces\FileUploadErrorInterface;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionException;

/**
 * Class AbstractTrack
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
abstract class AbstractTrack extends AbstractCrudService
{

    /**
     * @var TrackRepository
     */
    protected TrackRepository $trackRepository;

    /**
     * @var AlbumRepository
     */
    protected AlbumRepository $albumRepository;

    /**
     * @var AbstractEntityRepository
     */
    protected AbstractEntityRepository $trackCategoryRepository;

    /**
     * @param ServiceProviderInterface $serviceProvider
     * @param DatabasePack             $databasePack
     */
    public function __construct(ServiceProviderInterface $serviceProvider, DatabasePack $databasePack)
    {

        parent::__construct($serviceProvider, $databasePack);

        /** @var TrackRepository $trackRepository */
        $trackRepository = $this->getRepository(TrackEntity::class);
        $this->trackRepository = $trackRepository;

        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->getRepository(AlbumEntity::class);
        $this->albumRepository = $albumRepository;

        /** @var AlbumRepository $albumRepository */
        $trackCategoryRepository = $this->getRepository(TrackCategoryEntity::class);
        $this->trackCategoryRepository = $trackCategoryRepository;

    }

    /**
     * @param int $id
     *
     * @return ResponseApiCollectorService|bool
     * @throws StatementNotSelectedException
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    protected function getAlbumWhenExist(int $id): ResponseApiCollectorService|AlbumEntity
    {

        /** @var AlbumEntity|bool $finedAlbum */
        $finedAlbum = $this->albumRepository
            ->customFindById($id)
            ->entity()
            ->first();

        if (false === $finedAlbum) {
            return $this->createApiResponse(404, 'album@notExist');
        }

        return $finedAlbum;

    }

    /**
     * @param int $id
     *
     * @return ResponseApiCollectorService|TrackCategoryEntity
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    protected function getTrackCategoryWhenExist(int $id): ResponseApiCollectorService|TrackCategoryEntity
    {

        /** @var TrackCategoryEntity|bool $finedCategory */
        $finedCategory = $this->trackCategoryRepository
            ->customFindById($id)
            ->entity()
            ->first();

        if (false === $finedCategory) {
            return $this->createApiResponse(404, 'trackCategory@notExist');
        }

        return $finedCategory;

    }

    /**
     * @param int    $id
     * @param string $hash
     *
     * @return ResponseApiCollectorService|TrackEntity
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    protected function getTrackWhenExist(int $id, string $hash): ResponseApiCollectorService|TrackEntity
    {

        /** @var TrackEntity|bool $finedTrack */
        $finedTrack = $this->trackRepository
            ->customFindBy(compact($id, $hash))
            ->entity()
            ->first();

        if (false === $finedTrack) {
            return $this->createApiResponse(404, 'track@notExist');
        }

        return $finedTrack;

    }

    /**
     * @param int    $uniqueId
     * @param string $directoryName
     *
     * @return array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    #[ArrayShape([
        'isSuccess'        => "bool",
        'error'            => "bool|null|string",
        'pathWithFilename' => "string"
    ])]
    protected function uploadImage(int $uniqueId, string $directoryName): array
    {

        /** @var FileLoaderService $fileLoaderService */
        $fileLoaderService = $this->getService('FileLoader');

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        $makeUpload = $fileLoaderService
            ->initUploader('image')
            ->saveIn(sprintf('public/images/%s', $directoryName))
            ->numberFiles(1, 1)
            ->allowMimeTypes([
                'image/jpeg',
                'image/png',
                'image/jpg'
            ])
            ->allowExtensions(['jpg', 'jpeg', 'png'])
            // Redefining the error
            ->overrideError(
                FileUploadErrorInterface::MIME,
                $translationsFromDb->getTranslationByKey('common@invalidImageType')
            )
            ->overrideError(
                FileUploadErrorInterface::NUM_UPLOADS,
                $translationsFromDb->getTranslationByKey('track@numberOfImages')
            )
            // Load the image and change the name of the loaded image to a hash
            ->upload(function (array $fileData) use ($uniqueId) {
                return md5($fileData['name'] . $uniqueId);
            });

        $pathToSave = $fileLoaderService->getSaveIn();
        $uploadedFilename = $fileLoaderService->getUploadedFiles(true)['name'];
        $uploadedExtension = $fileLoaderService->getUploadedFiles(true)['extension'];

        return [
            'isSuccess'        => $makeUpload->isSuccess(),
            'error'            => $makeUpload->getFirstError() ?? null,
            'pathWithFilename' => sprintf('%s%s.%s', $pathToSave, $uploadedFilename, $uploadedExtension)
        ];

    }

    /**
     * @param Manager $manager
     *
     * @return ResponseApiCollectorService|bool
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    protected function validationWhenAddOrEditTrack(Manager $manager): static|bool
    {

        $validatedDataManager = $this->makeInputValidation($manager, new AddTrackValidation());
        $trackCategoryId = (int) $this->request->post()->get('category');
        $albumId = (int) $this->request->post()->get('album');

        $finedTrackCategory = $this->getTrackCategoryWhenExist($trackCategoryId);
        $finedAlbum = $this->getAlbumWhenExist($albumId);

        // Input data validation
        if (!$validatedDataManager->isValidation()) {
            return $this->setResponse(
                $this->apiResponse->create(400, $validatedDataManager->getErrors())
            );
        }

        // Checking for the existence of a track category
        if ($finedTrackCategory instanceof ResponseApiCollectorService) {
            return $this->setResponse($finedTrackCategory);
        }

        // Checking if an album exists
        if ($finedAlbum instanceof ResponseApiCollectorService) {
            return $this->setResponse($finedAlbum);
        }

        return true;

    }

}