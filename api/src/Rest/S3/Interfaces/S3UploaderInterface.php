<?php

namespace App\Rest\S3\Interfaces;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\User;
use App\Rest\S3\Uploader\UploadedFile as S3UploadedFile;
use Aws\Result;

/**
 * Interface S3UploaderInterface.
 *
 * @package  App\Rest\S3\Interfaces
 *
 * @author   Codememory
 */
interface S3UploaderInterface
{
    /**
     * @return string
     */
    public function getBucketName(): string;

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user): self;

    /**
     * @param EntityInterface $entity
     *
     * @return $this
     */
    public function setEntity(EntityInterface $entity): self;

    /**
     * @param string $pathInSystem
     * @param string $mimeType
     * @param array  $args
     *
     * @return Result
     */
    public function upload(string $pathInSystem, string $mimeType, array $args = []): Result;

    /**
     * @param null|string $oldFilePathInStorage
     * @param string      $newFilePathInSystem
     * @param string      $mimeType
     * @param array       $args
     *
     * @return null|Result
     */
    public function save(?string $oldFilePathInStorage, string $newFilePathInSystem, string $mimeType, array $args = []): ?Result;

    /**
     * @param string $pathInStorage
     * @param array  $argc
     *
     * @return Result
     */
    public function delete(string $pathInStorage, array $argc = []): Result;

    /**
     * @return S3UploadedFile
     */
    public function getUploadedFile(): S3UploadedFile;
}