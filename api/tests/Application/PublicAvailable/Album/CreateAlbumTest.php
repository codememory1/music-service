<?php

namespace App\Tests\Application\PublicAvailable\Album;

use App\Entity\Album;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ImageUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CreateAlbumTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/album/create', 'POST');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    public function testAccessDenied(): void
    {
        $authorizedUser = $this->authorize('user@gmail.com');

        $this->createRequest('/api/ru/public/album/create', 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    public function testTypeIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTypeNotExist(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
            'type' => 'InvalidType'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTitleIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
            'type' => 'SINGLE'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@titleIsRequired');
    }

    public function testTitleMaxLength(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
            'type' => 'SINGLE',
            'title' => 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxTitleLength');
    }

    public function testDescriptionIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
            'type' => 'SINGLE',
            'title' => 'Test Album'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@descriptionIsRequired');
    }

    public function testDescriptionMaxLength(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
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

    public function testImageIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
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

    public function testAllowedMimeTypeImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
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

    public function testMaxSizeImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
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

    public function testOnlyOneImage(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/album/create', 'POST', [
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

    public function testSuccessCreate(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createAlbum($authorizedUser);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::CREATE);
        $this->assertApiMessage('Альбом успешно создан');
        $this->assertArrayHasKey('id', $this->getApiResponseData());
        $this->assertIsInt($this->getApiResponseData()['id']);
    }

    /**
     * @depends testSuccessCreate
     */
    public function testSuccessFlushToDb(): void
    {
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbum = $albumRepository->find($this->createAlbum($authorizedUser));

        $this->assertNotNull($createdAlbum);
    }

    /**
     * @depends testSuccessFlushToDb
     */
    public function testSuccessSaveImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $albumRepository = $this->em()->getRepository(Album::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $createdAlbum = $albumRepository->find($this->createAlbum($authorizedUser));

        $this->assertNotNull($imageUploader->getObject($createdAlbum->getImage()));
    }
}