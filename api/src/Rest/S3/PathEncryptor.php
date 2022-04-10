<?php

namespace App\Rest\S3;

/**
 * Class PathEncryptor.
 *
 * @package App\Rest\S3
 *
 * @author  codememory
 */
class PathEncryptor
{
    /**
     * @param array $data
     *
     * @return bool|string
     */
    public function encrypt(array $data): bool|string
    {
        $data['timestamp'] = microtime(true);

        return hash('sha3-512', implode('_', $data));
    }
}