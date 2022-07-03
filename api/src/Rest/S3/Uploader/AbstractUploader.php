<?php

namespace App\Rest\S3\Uploader;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\User;
use App\Rest\S3\Client;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\S3\ObjectPath;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use App\Service\MimeTypeConverter;
use Aws\Result;
use JetBrains\PhpStorm\Pure;
use LogicException;

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
    protected ?User $user = null;
    protected ?EntityInterface $entity = null;
    private array $uploadedPaths = [];
    private ObjectPath $objectPath;

    public function __construct(Client $client, MimeTypeConverter $mimeTypeConverter, ObjectPath $objectPath)
    {
        $this->client = $client;
        $this->mimeTypeConverter = $mimeTypeConverter;
        $this->objectPath = $objectPath;

        $this->client->bucket->create($this->getBucketName());
    }

    protected function generateKey(string $pathInSystem, string $mimeType, bool $asPathInStorage = false): string
    {
        if (null === $this->user) {
            throw new LogicException('To create a hash of a file, you need to specify a user');
        }

        if (null === $this->entity) {
            throw new LogicException('To create a hash of a file, you need to specify the entity to which this file will belong');
        }

        $contentHash = sha1($this->getContent($pathInSystem));
        $uniqueHash = hash('sha3-512', "{$this->user->getId()}_{$this->entity->getId()}");
        $fileExtensionFromMimeType = $this->mimeTypeConverter->convertToExtension($mimeType);
        $generatedKey = "${contentHash}_${uniqueHash}.${fileExtensionFromMimeType}";
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

    public function setUser(User $user): S3UploaderInterface
    {
        $this->user = $user;

        return $this;
    }

    public function setEntity(EntityInterface $entity): S3UploaderInterface
    {
        $this->entity = $entity;

        return $this;
    }

    public function upload(string $pathInSystem, string $mimeType, array $args = []): Result
    {
        return $this->client->awsS3Client->putObject([
            'Bucket' => $this->getBucketName(),
            'Key' => $this->generateKey($pathInSystem, $mimeType),
            'Body' => $this->getContent($pathInSystem),
            'ContentType' => $mimeType,
            ...$args
        ]);
    }

    public function save(?string $oldFilePathInStorage, string $newFilePathInSystem, string $mimeType, array $args = []): ?Result
    {
        if (null === $oldFilePathInStorage) {
            return $this->upload($newFilePathInSystem, $mimeType);
        } elseif ($oldFilePathInStorage !== $this->generateKey($newFilePathInSystem, $mimeType, true)) {
            $this->delete($oldFilePathInStorage);

            return $this->upload($newFilePathInSystem, $mimeType);
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