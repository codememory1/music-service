<?php

namespace App\Rest\S3;

use Aws\S3\S3Client as AwsS3Client;

class Client
{
    public function __construct(
        public readonly AwsS3Client $awsS3Client,
        public readonly Bucket $bucket)
    {}
}