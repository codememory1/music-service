<?php

namespace App\Tests\Traits;

use App\Entity\UserSession;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait MultimediaTrait
{
    private function createAlbum(UserSession $authorizedUser): ?int
    {
        $this->createRequest('/api/ru/public/album/create', 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Description for test album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('image_1.3mb.jpg'),
                'image_1.3mb.jpg'
            )
        ]);

        return $this->getApiResponseData()['id'] ?? null;
    }
}