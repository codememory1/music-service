<?php

namespace App\Rest\S3;

use Aws\Result;
use Aws\S3\S3Client as AwsS3Client;

/**
 * Class Bucket.
 *
 * @package App\Rest\S3
 *
 * @author  Codememory
 */
class Bucket
{
    /**
     * @var AwsS3Client
     */
    private AwsS3Client $awsS3Client;

    /**
     * @var null|Result
     */
    private ?Result $listBuckets = null;

    /**
     * @param AwsS3Client $awsS3Client
     */
    public function __construct(AwsS3Client $awsS3Client)
    {
        $this->awsS3Client = $awsS3Client;
    }

    /**
     * @param string $name
     * @param string $acl
     * @param array  $args
     *
     * @return bool|Result
     */
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

    /**
     * @param string $name
     * @param array  $args
     *
     * @return bool|Result
     */
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

    /**
     * @param string $name
     *
     * @return $this
     */
    public function clear(string $name): static
    {
        $objects = $this->awsS3Client->listObjects([
            'Bucket' => $name
        ]);

        foreach ($objects->get('Contents') as $object) {
            $this->awsS3Client->deleteObject([
                'Bucket' => $name,
                'Key' => $object['Key'],
            ]);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function exist(string $name): bool
    {
        foreach ($this->all() as $bucket) {
            if ($bucket['Name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function all(array $args = []): array
    {
        if (null === $this->listBuckets) {
            $this->listBuckets = $this->awsS3Client->listBuckets($args);
        }

        return $this->listBuckets->toArray()['Buckets'];
    }
}