<?php

namespace App\Rest\S3\Uploader;

use App\Rest\S3\Client;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\ObjectPath;
use App\Rest\S3\PathEncryptor;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use App\Service\MimeTypeConverter;
use Aws\Result;
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
     * @var ObjectPath
     */
    private ObjectPath $objectPath;

    /**
     * @param Client            $client
     * @param PathEncryptor     $pathEncryptor
     * @param MimeTypeConverter $mimeTypeConverter
     * @param ObjectPath        $objectPath
     */
    public function __construct(Client $client, PathEncryptor $pathEncryptor, MimeTypeConverter $mimeTypeConverter, ObjectPath $objectPath)
    {
        $this->client = $client;
        $this->pathEncryptor = $pathEncryptor;
        $this->mimeTypeConverter = $mimeTypeConverter;
        $this->objectPath = $objectPath;

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
        $this->objectPath->setPath($path);

        return $this->client->awsS3Client->deleteObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->objectPath->getKey(),
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