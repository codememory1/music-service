<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Entity\Album;
use App\Entity\UserSession;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ImageUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UpdateAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAuthorizeIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAccessDenied(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);
        $authorizedUser = $this->authorize('user@gmail.com');

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAlbumNotExist(): void
    {
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->createRequest('/api/ru/public/album/0/edit', 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testAlbumNotBelongToMe(): void
    {
        $ownerAlbum = $this->createArtistAccount('owner-album@gmail.com');
        $albumId = $this->createAlbum($this->authorize($ownerAlbum));
        $authorizedUser = $this->authorize('developer@gmail.com');

        $this->assertNotNull($albumId);
        $this->createRequest("/api/ru/public/album/{$albumId}/edit", 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@album');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testTypeIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testTypeNotExist(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'InvalidType'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testTitleIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@titleIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testTitleMaxLength(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxTitleLength');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testDescriptionIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@descriptionIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testDescriptionMaxLength(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxDescriptionLength');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testImageIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Description for test album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@imageIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAllowedMimeTypeImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Description for test album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('text_2.5mb.txt'),
                'text_2.5mb.txt'
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@uploadFileNotImage');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testMaxSizeImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Description for test album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('image_18mb.png'),
                'image_18mb.png'
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxSizeImage');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testOnlyOneImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->createRequest("/api/ru/public/album/{$createdAlbumId}/edit", 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album',
            'description' => 'Description for test album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'image' => [
                new UploadedFile(
                    $this->getFilePathFromFixture('image_1.3mb.jpg'),
                    'image_1.3mb.jpg'
                ),
                new UploadedFile(
                    $this->getFilePathFromFixture('image_2mb.png'),
                    'image_2mb.png'
                )
            ]
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@onlyOneImage');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUpdate(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->updateAlbum($authorizedUser, $createdAlbumId);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::UPDATE);
        $this->assertApiMessage('Альбом успешно обновлен');
    }

    /**
     * @depends testSuccessUpdate
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessFlushToDb(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $this->updateAlbum($authorizedUser, $createdAlbumId);

        $updatedAlbum = $albumRepository->find($createdAlbumId);

        $this->assertSame('DOUBLE', $updatedAlbum->getType()->getKey());
        $this->assertSame('Edit title', $updatedAlbum->getTitle());
        $this->assertSame('Edit description', $updatedAlbum->getDescription());
        $this->assertStringEndsWith('.png', $updatedAlbum->getImage());
    }

    /**
     * @depends testSuccessUpdate
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessUpdateImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbumId = $this->createAlbum($authorizedUser);

        $createdAlbum = $albumRepository->find($createdAlbumId);

        $this->updateAlbum($authorizedUser, $createdAlbumId);

        $this->em()->clear();

        $updatedAlbum = $albumRepository->find($createdAlbumId);

        $this->assertNull($imageUploader->getObject($createdAlbum->getImage())); // The old image should be removed from S3
        $this->assertNotNull($imageUploader->getObject($updatedAlbum->getImage())); // The new image should be saved in S3
    }

    private function updateAlbum(UserSession $authorizedUser, int $id): void
    {
        $this->createRequest("/api/ru/public/album/{$id}/edit", 'POST', [
            'type' => 'DOUBLE',
            'title' => 'Edit title',
            'description' => 'Edit description'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('image_2mb.png'),
                'image_2mb.png'
            )
        ]);
    }
}