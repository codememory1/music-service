<?php

namespace App\Rest\S3;

use Aws\Result;
use Exception;
use GuzzleHttp\Psr7\Stream;

class UploadedObject
{
    public function __construct(
        private readonly Client $client,
        private readonly ObjectPath $objectPath
    ) {
    }

    public function getObject(string $path, bool $asStream = false): null|Result|Stream
    {
        $this->objectPath->setPath($path);

        try {
            $object = $this->client->awsS3Client->getObject([
                'Bucket' => $this->objectPath->getBucket(),
                'Key' => $this->objectPath->getKey()
            ]);

            if ($asStream) {
                return $object['Body'];
            }

            return $object;
        } catch (Exception) {
            return null;
        }
    }

    public function createTempFile(Stream $stream): mixed
    {
        $tempFile = tmpfile();

        fwrite($tempFile, $stream->getContents());

        $streamMetadata = stream_get_meta_data($tempFile);

        chmod($streamMetadata['uri'], 0777);

        return $tempFile;
    }
}