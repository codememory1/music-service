<?php

namespace App\Services\Track;

use App\Services\AbstractApiService;
use App\Services\FileLoaderService;
use App\Services\ResponseApiCollectorService;
use App\Services\Translation\DataService;
use Benlipp\SrtParser\Caption;
use Benlipp\SrtParser\Exceptions\FileNotFoundException;
use Benlipp\SrtParser\Parser;
use Codememory\Components\Services\Exceptions\ServiceNotExistException;
use Codememory\HttpFoundation\Interfaces\FileUploadErrorInterface;
use Codememory\HttpFoundation\Interfaces\MakeUploadInterface;
use JetBrains\PhpStorm\Pure;
use ReflectionException;

/**
 * Class SubtitleTypeHandlerService
 *
 * @package App\Services\Track
 *
 * @author  Danil
 */
class SubtitleTypeHandlerService extends AbstractApiService
{

    /**
     * @return ResponseApiCollectorService|array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     */
    public function manualType(): ResponseApiCollectorService|array
    {

        $subtitles = $this->request->post()->get('subtitles');
        $subtitles = !is_array($subtitles) ? [] : $subtitles;

        // Checking for the existence of subtitles in manual adding
        if ([] === $subtitles) {
            return $this->createApiResponse(400, 'track@subtitleManualIsRequired');
        }

        $subtitlesSchema = new SubtitleSchema($subtitles);

        // Checking the subtitle format
        if (!$subtitlesSchema->isValid() || []) {
            return $this->createApiResponse(400, 'track@subtitleInvalidFormat');
        }

        return $subtitles;

    }

    /**
     * @return ResponseApiCollectorService|array
     * @throws ReflectionException
     * @throws ServiceNotExistException
     * @throws FileNotFoundException
     */
    public function fileType(): ResponseApiCollectorService|array
    {

        /** @var FileLoaderService $loader */
        /** @var MakeUploadInterface $make */
        [$loader, $make] = $this->uploadFileSubtitle();

        if (!$make->isSuccess()) {
            return $this->apiResponse->create(400, $make->getErrors());
        }

        $uploadedFilePath = $this->getUploadedFilePath($loader, $loader->getUploadedFiles(true));

        // Parse subtitle file
        $subtitles = (new Parser())->loadFile($uploadedFilePath)->parse();
        $subtitles = array_map(fn (Caption $caption) => $caption->toArray(), $subtitles);

        // Delete the downloaded subtitle file
        $this->get('filesystem')->remove($uploadedFilePath);

        return $subtitles;

    }

    /**
     * @return array
     * @throws ServiceNotExistException
     * @throws ReflectionException
     */
    private function uploadFileSubtitle(): array
    {

        /** @var FileLoaderService $fileLoaderService */
        $fileLoaderService = $this->getService('FileLoader');

        /** @var DataService $translationsFromDb */
        $translationsFromDb = $this->getService('Translation\Data');

        $makeUpload = $fileLoaderService
            ->initUploader('subtitle_file')
            ->saveIn('/storage/temp')
            ->allowMimeTypes(['application/x-subrip'])
            ->allowExtensions(['srt'])
            ->overrideError(
                FileUploadErrorInterface::NUM_UPLOADS,
                $translationsFromDb->getTranslationByKey('track@numberSubtitleFiles')
            )
            ->overrideError(
                FileUploadErrorInterface::MIME,
                $translationsFromDb->getTranslationByKey('track@subtitleMimeType')
            )
            ->overrideError(
                FileUploadErrorInterface::EXTENSION,
                $translationsFromDb->getTranslationByKey('track@subtitleExtension')
            )
            ->upload();

        return [$fileLoaderService, $makeUpload];

    }

    /**
     * @param FileLoaderService $loader
     * @param array             $fileData
     *
     * @return string
     */
    #[Pure]
    private function getUploadedFilePath(FileLoaderService $loader, array $fileData): string
    {

        return sprintf('%s%s.%s', $loader->getSaveIn(), $fileData['name'], $fileData['extension']);

    }

}