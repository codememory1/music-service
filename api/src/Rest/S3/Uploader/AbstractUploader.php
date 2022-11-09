<?php

namespace App\Rest\S3\Uploader;

use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Infrastructure\File\MimeTypeConverter;
use App\Rest\S3\Client;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\ObjectPath;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use Aws\Result;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    protected function generateKey(UploadedFile $file, string $propertyName, EntityS3SettingInterface $entityS3Setting): string
    {
        return sprintf(
            '%s/%s_%s.%s',
            $entityS3Setting->getFolderName()->value,
            $this->generateContentHash($file->getRealPath()),
            $this->generateUniqueHash($propertyName . $entityS3Setting->getUuid()),
            $this->getExtensionFromMimeType($file->getMimeType())
        );
    }

    protected function generateKeyWithBucket(string $generatedKey): string
    {
        $generatedKeyWithBucket = sprintf('%s/%s', $this->getBucketName(), $generatedKey);

        $this->uploadedPaths[] = $generatedKeyWithBucket;

        return $generatedKeyWithBucket;
    }

    protected function getContent(string $path): ?string
    {
        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return null;
    }

    public function upload(
        UploadedFile $file,
        string $propertyName,
        EntityS3SettingInterface $entityS3Setting,
        array $args = []
    ): Result {
        $this->generateKeyWithBucket($this->generateKey($file, $propertyName, $entityS3Setting));

        return $this->client->awsS3Client->putObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->generateKey($file, $propertyName, $entityS3Setting),
            'Body' => $this->getContent($file->getRealPath()),
            'ContentType' => $file->getMimeType(),
            ...$args
        ]);
    }

    public function save(
        ?string $oldFilePathInStorage,
        UploadedFile $file,
        string $propertyName,
        EntityS3SettingInterface $entityS3Setting,
        array $args = []
    ): ?Result {
        if (null === $oldFilePathInStorage) {
            return $this->upload($file, $propertyName, $entityS3Setting, $args);
        }

        $generatedKeyWithBucket = $this->generateKeyWithBucket(
            $this->generateKey($file, $propertyName, $entityS3Setting)
        );

        if ($oldFilePathInStorage !== $generatedKeyWithBucket) {
            $this->delete($oldFilePathInStorage, $args);

            return $this->upload($file, $propertyName, $entityS3Setting, $args);
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

    public function getObject(string $pathInStorage, array $argc = []): ?Result
    {
        $this->objectPath->setPath($pathInStorage);

        try {
            return $this->client->awsS3Client->getObject([
                'Bucket' => $this->getBucketName(),
                'Key' => $this->objectPath->getKey(),
                ...$argc
            ]);
        } catch (Exception) {
            return null;
        }
    }

    #[Pure]
    public function getUploadedFile(): S3UploadedFile
    {
        return new S3UploadedFile($this->uploadedPaths);
    }
}