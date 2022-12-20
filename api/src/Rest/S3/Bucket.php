<?php

namespace App\Rest\S3;

use Aws\Result;
use Aws\S3\S3Client as AwsS3Client;

class Bucket
{
    private ?Result $listBuckets = null;

    public function __construct(
        public readonly AwsS3Client $awsS3Client
    ) {
    }

    public function create(string $name, string $acl = 'private-read-write', array $args = []): Result|bool
    {
        if (!$this->exist($name)) {
            return $this->awsS3Client->createBucket([
                'ACL' => $acl,
                'Bucket' => $name,
                ...$args
            ]);
        }

        return false;
    }

    public function remove(string $name, array $args = []): Result|bool
    {
        if ($this->exist($name)) {
            $this->clear($name);

            return $this->awsS3Client->deleteBucket([
                'Bucket' => $name,
                ...$args
            ]);
        }

        return false;
    }

    public function clear(string $name): static
    {
        $objects = $this->awsS3Client->getIterator('ListObjects', ([
            'Bucket' => $name
        ]));

        foreach ($objects as $object) {
            $this->awsS3Client->deleteObject([
                'Bucket' => $name,
                'Key' => $object['Key'],
            ]);
        }

        return $this;
    }

    public function clearAllBuckets(): void
    {
        foreach ($this->all() as $bucket) {
            $this->clear($bucket['Name']);
        }
    }

    public function exist(string $name): bool
    {
        foreach ($this->all() as $bucket) {
            if ($bucket['Name'] === $name) {
                return true;
            }
        }

        return false;
    }

    public function all(array $args = []): array
    {
        if (null === $this->listBuckets) {
            $this->listBuckets = $this->awsS3Client->listBuckets($args);
        }

        return $this->listBuckets->toArray()['Buckets'];
    }
}