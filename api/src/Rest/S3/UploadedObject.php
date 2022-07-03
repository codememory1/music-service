<?php

namespace App\Rest\S3;

use Aws\Result;
use Exception;
use GuzzleHttp\Psr7\Stream;

/**
 * Class UploadedObject.
 *
 * @package App\Rest\S3
 *
 * @author  Codememory
 */
class UploadedObject
{
    private Client $client;
    private ObjectPath $objectPath;

    public function __construct(Client $client, ObjectPath $objectPath)
    {
        $this->client = $client;
        $this->objectPath = $objectPath;
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