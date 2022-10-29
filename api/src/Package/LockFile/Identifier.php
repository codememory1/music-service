<?php

namespace App\Package\LockFile;

class Identifier
{
    public function uniqueFromData(array $data): int
    {
        return count($data) + 1;
    }

    public function prevFromData(array $data): int
    {
        $count = count($data);

        return 0 === $count ? 0 : $count - 1;
    }
}