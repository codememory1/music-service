<?php

namespace App\Rest\S3\Uploader;

use App\Interfaces\S3UploaderInterface;
use App\Rest\S3\Client;
use App\Rest\S3\PathEncryptor;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use App\Service\MimeTypeConverter;
use Aws\Result;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\File\UploadedFile as HttpUploadedFile;

/**
 * Class AbstractUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
abstract class AbstractUploader implements S3UploaderInterface
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var PathEncryptor
     */
    protected PathEncryptor $pathEncryptor;

    /**
     * @var MimeTypeConverter
     */
    protected MimeTypeConverter $mimeTypeConverter;

    /**
     * @var array
     */
    private array $uploadedPaths = [];

    /**
     * @param Client            $client
     * @param PathEncryptor     $pathEncryptor
     * @param MimeTypeConverter $mimeTypeConverter
     */
    public function __construct(Client $client, PathEncryptor $pathEncryptor, MimeTypeConverter $mimeTypeConverter)
    {
        $this->client = $client;
        $this->pathEncryptor = $pathEncryptor;
        $this->mimeTypeConverter = $mimeTypeConverter;

        $this->client->bucket->create($this->getBucketName());
    }

    /**
     * @param HttpUploadedFile $uploadedFile
     * @param array            $dataForName
     *
     * @return string
     */
    protected function generateKey(HttpUploadedFile $uploadedFile, array $dataForName): string
    {
        $extension = $this->mimeTypeConverter->convertToExtension($uploadedFile->getMimeType());
        $path = sprintf(
            '%s.%s',
            $this->pathEncryptor->encrypt($dataForName),
            $extension
        );

        $this->uploadedPaths[] = sprintf('%s/%s', $this->getBucketName(), $path);

        return $path;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    #[ArrayShape([
        'bucket' => 'string',
        'key' => 'string'
    ])]
    protected function getDataFromPath(string $path): array
    {
        return [
            'bucket' => explode('/', $path)[0],
            'key' => mb_substr($path, mb_strpos($path, '/'))
        ];
    }

    /**
     * @inheritDoc
     */
    public function upload(HttpUploadedFile $uploadedFile, array $dataForName, array $args = []): Result
    {
        return $this->client->awsS3Client->putObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->generateKey($uploadedFile, $dataForName),
            'Body' => $uploadedFile->getContent(),
            'ContentType' => $uploadedFile->getMimeType(),
            ...$args
        ]);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path, array $argc = []): Result
    {
        return $this->client->awsS3Client->deleteObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->getDataFromPath($path)['key'],
            ...$argc
        ]);
    }

    /**
     * @inheritDoc
     */
    #[Pure]
    public function getUploadedFile(): S3UploadedFile
    {
        return new UploadedFile($this->uploadedPaths);
    }
}