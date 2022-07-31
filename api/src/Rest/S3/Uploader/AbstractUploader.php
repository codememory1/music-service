<?php

namespace App\Rest\S3\Uploader;

use App\Rest\S3\Client;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\ObjectPath;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use App\Service\MimeTypeConverter;
use Aws\Result;
use JetBrains\PhpStorm\Pure;

/**
 * Class AbstractUploader.
 *
 * @package App\Rest\S3\Uploader
 *
 * @author  Codememory
 */
abstract class AbstractUploader implements S3UploaderInterface
{
    protected Client $client;
    protected MimeTypeConverter $mimeTypeConverter;
    private array $uploadedPaths = [];
    private ObjectPath $objectPath;

    public function __construct(Client $client, MimeTypeConverter $mimeTypeConverter, ObjectPath $objectPath)
    {
        $this->client = $client;
        $this->mimeTypeConverter = $mimeTypeConverter;
        $this->objectPath = $objectPath;

        $this->client->bucket->create($this->getBucketName());
    }

    protected function getExtensionFromMimeType(string $mimeType): string
    {
        return $this->mimeTypeConverter->convertToExtension($mimeType);
    }

    #[Pure]
    protected function generateContentHash(string $pathInSystem): string
    {
        return sha1($this->getContent($pathInSystem));
    }

    protected function generateUniqueHash(string $uuid): string
    {
        return hash('sha3-512', $uuid);
    }

    protected function generateFileName(string $pathInSystem, string $mimeType, string $uuid): string
    {
        return sprintf(
            '%s_%s.%s',
            $this->generateContentHash($pathInSystem),
            $this->generateUniqueHash($uuid),
            $this->getExtensionFromMimeType($mimeType)
        );
    }

    protected function generateKey(string $pathInSystem, string $mimeType, string $uuid, bool $asPathInStorage = false): string
    {
        $generatedKey = $this->generateFileName($pathInSystem, $mimeType, $uuid);
        $generatedKeyWithBucket = sprintf('%s/%s', $this->getBucketName(), $generatedKey);

        $this->uploadedPaths[] = $generatedKeyWithBucket;

        if ($asPathInStorage) {
            return $generatedKeyWithBucket;
        }

        return $generatedKey;
    }

    protected function getContent(string $path): ?string
    {
        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return null;
    }

    public function upload(string $pathInSystem, string $mimeType, string $uuid, array $args = []): Result
    {
        return $this->client->awsS3Client->putObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->generateKey($pathInSystem, $mimeType, $uuid),
            'Body' => $this->getContent($pathInSystem),
            'ContentType' => $mimeType,
            ...$args
        ]);
    }

    public function save(?string $oldFilePathInStorage, string $newFilePathInSystem, string $mimeType, string $uuid, array $args = []): ?Result
    {
        if (null === $oldFilePathInStorage) {
            return $this->upload($newFilePathInSystem, $mimeType, $uuid);
        } elseif ($oldFilePathInStorage !== $this->generateKey($newFilePathInSystem, $mimeType, $uuid, true)) {
            $this->delete($oldFilePathInStorage);

            return $this->upload($newFilePathInSystem, $mimeType, $uuid);
        }

        return null;
    }

    public function delete(string $pathInStorage, array $argc = []): Result
    {
        $this->objectPath->setPath($pathInStorage);

        return $this->client->awsS3Client->deleteObject([
            'Bucket' => $this->objectPath->getBucket(),
            'Key' => $this->objectPath->getKey(),
            ...$argc
        ]);
    }

    #[Pure]
    public function getUploadedFile(): S3UploadedFile
    {
        return new UploadedFile($this->uploadedPaths);
    }
}