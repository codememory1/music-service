<?php

namespace App\Rest\S3;

use Aws\S3\S3Client as AwsS3Client;

/**
 * Class Client.
 *
 * @package App\Rest\S3
 *
 * @author  Codememory
 */
class Client
{
    /**
     * @var AwsS3Client
     */
    public readonly AwsS3Client $awsS3Client;

    /**
     * @var Bucket
     */
    public readonly Bucket $bucket;

    /**
     * @param AwsS3Client $awsS3Client
     * @param Bucket      $bucket
     */
    public function __construct(AwsS3Client $awsS3Client, Bucket $bucket)
    {
        $this->awsS3Client = $awsS3Client;
        $this->bucket = $bucket;
    }
}