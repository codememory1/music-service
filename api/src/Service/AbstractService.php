<?php

namespace App\Service;

use App\Dto\Interfaces\DataTransferInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Rest\Http\ResponseCollection;
use App\Rest\S3\Interfaces\S3UploaderInterface;
use App\Rest\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractService
{
    protected readonly EntityManagerInterface $em;
    protected readonly FlusherService $flusherService;
    protected readonly Validator $validator;
    protected readonly ResponseCollection $responseCollection;

    public function __construct(
        EntityManagerInterface $manager,
        FlusherService $flusherService,
        Validator $validator,
        ResponseCollection $responseCollection
    ) {
        $this->em = $manager;
        $this->flusherService = $flusherService;
        $this->validator = $validator;
        $this->responseCollection = $responseCollection;
    }

    protected function validate(EntityInterface|DataTransferInterface $object, ?callable $customResponse = null): void
    {
        $this->validator->validate($object, $customResponse);
    }

    protected function validateWithEntity(DataTransferInterface $dataTransfer): void
    {
        $this->validate($dataTransfer);
        $this->validate($dataTransfer->getEntity());
    }

    protected function simpleFileUpload(S3UploaderInterface $s3Uploader, ?string $oldPath, UploadedFile $uploadedFile, string $propertyName, EntityS3SettingInterface $entityS3Setting): ?string
    {
        $s3Uploader->save($oldPath, $uploadedFile, $propertyName, $entityS3Setting);

        return $s3Uploader->getUploadedFile()->first();
    }
}