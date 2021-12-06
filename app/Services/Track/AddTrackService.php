<?php

namespace App\Services\Track;

use App\Orm\Entities\TrackEntity;
use App\Orm\Repositories\TrackRepository;
use App\Services\AbstractApiService;
use App\Services\Album\AlbumService;
use App\Services\FileLoaderService;
use App\Services\ResponseApiCollectorService;
use App\Services\TrackCategory\CategoryService;
use App\Services\Translation\DataService;
use App\Validations\Track\AddTrackValidation;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\Components\Validator\Interfaces\ValidationManagerInterface;
use Codememory\Components\Validator\Manager as ValidationManager;
use Codememory\HttpFoundation\Interfaces\FileUploadErrorInterface;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use ReflectionException;

/**
 * Class AddTrackService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class AddTrackService extends AbstractApiService
{

    /**
     * @param ValidationManager $validationManager
     * @param TrackRepository   $trackRepository
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws StatementNotSelectedException
     */
    final public function make(ValidationManager $validationManager, TrackRepository $trackRepository): ResponseApiCollectorService
    {

        /** @var CategoryService $trackCategoryService */
        $trackCategoryService = $this->getService('TrackCategory\Category');

        /** @var AlbumService $trackCategoryService */
        $albumRepository = $this->getService('Album\Album');
        $inputValidation = $this->inputValidation($validationManager);

        // Input data validation
        if (!$inputValidation->isValidation()) {
            return $this->apiResponse->create(400, $inputValidation->getErrors());
        }

        // Checking for the existence of a track category
        if (!$trackCategoryService->exist((int) $this->request->post()->get('category'))) {
            return $this->createApiResponse(404, 'trackCategory@notExist');
        }

        // Checking if an album exists
        if (!$albumRepository->exist((int) $this->request->post()->get('album'))) {
            return $this->createApiResponse(404, 'album@notExist');
        }

        $dataUploadImage = $this->imageUpload($trackRepository);

        // Checking image loading
        if (!$dataUploadImage['isSuccess']) {
            return $this->apiResponse->create(400, [$dataUploadImage['error']]);
        }

        return $this->trackPush($dataUploadImage['pathWithFilename']);

    }

    /**
     * @param ValidationManager $validationManager
     *
     * @return ValidationManagerInterface
     */
    private function inputValidation(ValidationManager $validationManager): ValidationManagerInterface
    {

        return $validationManager->create(new AddTrackValidation(), $this->request->post()->all());

    }

    /**
     * @param TrackRepository $trackRepository
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
    private function imageUpload(TrackRepository $trackRepository): array
    {

        /** @var FileLoaderService $fileLoaderService */
        $fileLoaderService = $this->getService('FileLoader');

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        $makeUpload = $fileLoaderService
            ->initUploader('image')
            ->saveIn('public/images/tracks')
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
            ->upload(function (array $fileData) use ($trackRepository) {
                return md5($fileData['name'] . $trackRepository->getMaxId() + 1);
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
     * @param string $imagePath
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    private function trackPush(string $imagePath): ResponseApiCollectorService
    {

        $trackEntity = new TrackEntity();

        $trackEntity
            ->setHash(Uuid::uuid4()->toString())
            ->setName($this->request->post()->get('name'))
            ->setCategoryId($this->request->post()->get('category'))
            ->setImage($imagePath)
            ->setText($this->request->post()->get('text'))
            ->setAlbumId($this->request->post()->get('album'))
            ->setDurationTime($this->request->post()->get('duration_time'))
            ->setFoulLanguage($this->request->post()->get('foul_language'));

        $this->getEntityManager()->commit($trackEntity)->flush();

        return $this->createApiResponse(200, 'track@successAdd');

    }

}