<?php

namespace App\Tests\Application\PublicAvailable\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaCategory;
use App\Entity\PlatformSetting;
use App\Enum\MultimediaStatusEnum;
use App\Enum\MultimediaTypeEnum;
use App\Enum\PlatformSettingEnum;
use App\Enum\PlatformSettingValueKeyEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UploadMultimediaTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    private array $validData = [
        'type' => MultimediaTypeEnum::TRACK,
        'title' => 'My Title for Multimedia',
        'description' => 'My Description for Multimedia',
        'multimedia' => 'music_5.9mb_00-32time.wav',
        'category' => 'multimediaCategoryTitle@sport',
        'text' => [
            'ru' => 'Русский текст мультимедиа',
            'en' => 'English text for multimedia'
        ],
        'subtitles' => 'subtitles_202B_valid.srt',
        'is_obscene_words' => true,
        'image' => 'image_2mb.png',
        'producer' => 'Danil, Jon',
        'performers' => ['developer@gmail.com', 'user@gmail.com']
    ];

    public function testAuthorizeIsRequired(): void
    {
        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST');

        $this->assertApiStatusCode(401);
        $this->assertApiType(ResponseTypeEnum::CHECK_AUTH);
        $this->assertApiMessage('auth@authRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAccessDenied(): void
    {
        $authorizedUser = $this->authorize('user@gmail.com');

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', server: [
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
    public function testTypeIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', server: [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@typeIsRequired');
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

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => 'InvalidType'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@typeIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testAlbumIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
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
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => 0
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
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
        $authorizedUser = $this->authorize($this->createArtistAccount());

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
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
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@titleIsRequired');
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
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@titleMaxLength');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function tesDescriptionMaxLength(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@descriptionMaxLength');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCategoryIsRequired(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@categoryIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCategoryNotExist(): void
    {
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => 0
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@categoryIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testMultimediaIsRequired(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@multimediaIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidMimeTypeSubtitles(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture('image_1.3mb.jpeg'),
                'image_1.3mb.jpeg'
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@uploadFileIsNotSubtitles');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testIsObsceneWordsIsRequired(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@isObsceneWordsIsRequired');
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
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@previewIsRequired');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidMimeTypeImage(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('text_2.5mb.txt'),
                'text_2.5mb.txt'
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@uploadFileIsNotPreview');
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
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture('image_17.8mb.jpeg'),
                'image_17.8mb.jpeg'
            )
        ]);

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@maxSizePreview');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testPerformerNotExist(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => ['invalid-performer@gmail.com']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@performer');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidMimeTypeTrack(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture('video_544kb_00-31time.mp4'),
                'video_544kb_00-31time.mp4'
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('multimedia@invalidTrackMimeType');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidMimeTypeClip(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => MultimediaTypeEnum::CLIP->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture('music_5.8mb_02-23time.mp3'),
                'music_5.8mb_02-23time.mp3'
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('multimedia@invalidClipMimeType');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidSubtitles(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture('subtitles_182B_not_valid.srt'),
                'subtitles_182B_not_valid.srt'
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidSubtitles');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidDurationToClip(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->changeMultimediaDurationToPlatformSetting(120, 60);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => MultimediaTypeEnum::CLIP->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture('video_50.2mb_01-32time.mp4'),
                'video_50.2mb_01-32.mp4'
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('multimedia@badDuration');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testInvalidDurationToTrack(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->changeMultimediaDurationToPlatformSetting(120, 60);

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture('music_5.8mb_02-23time.wav'),
                'music_5.8mb_02023time.wav'
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('multimedia@badDuration');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUpload(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'text' => $this->validData['text'],
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::CREATE);
        $this->assertApiMessage('Мультимедия успешно добавлена и ожидает отправки на модерацию');
        $this->assertArrayHasKey('id', $this->getApiResponseData());
        $this->assertIsInt($this->getApiResponseData()['id']);
    }

    /**
     * @depends testSuccessUpload
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSuccessFlushToDb(): void
    {
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'text' => $this->validData['text'],
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $uploadedMultimedia = $multimediaRepository->find($this->getApiResponseData()['id']);

        $this->assertEquals($this->validData['type']->name, $uploadedMultimedia->getType());
        $this->assertEquals($albumId, $uploadedMultimedia->getAlbum()->getId());
        $this->assertEquals($this->validData['title'], $uploadedMultimedia->getTitle());
        $this->assertEquals($this->validData['description'], $uploadedMultimedia->getDescription());
        $this->assertEquals($categoryId, $uploadedMultimedia->getCategory()->getId());
        $this->assertEquals($this->validData['text'], $uploadedMultimedia->getText());
        $this->assertEquals($this->validData['is_obscene_words'], $uploadedMultimedia->isObsceneWords());
        $this->assertEquals($this->validData['performers'], $uploadedMultimedia->getEmailPerformers());
        $this->assertNotNull($uploadedMultimedia->getMultimedia());
        $this->assertNotNull($uploadedMultimedia->getSubtitles());
        $this->assertNotNull($uploadedMultimedia->getImage());
        $this->assertEquals(MultimediaStatusEnum::DRAFT->name, $uploadedMultimedia->getStatus());
        $this->assertNull($uploadedMultimedia->getQueue());
    }

    /**
     * @depends testSuccessUpload
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUploadClipToS3(): void
    {
        $clipUploader = $this->getService(ClipUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => MultimediaTypeEnum::CLIP->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture('video_544kb_00-31time.mp4'),
                'video_544kb_00-31time.mp4'
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $uploadedMultimedia = $multimediaRepository->find($this->getApiResponseData()['id']);

        $this->assertNotNull($clipUploader->getObject($uploadedMultimedia->getMultimedia()));
    }

    /**
     * @depends testSuccessUpload
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUploaderTrackToS3(): void
    {
        $trackUploader = $this->getService(TrackUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $uploadedMultimedia = $multimediaRepository->find($this->getApiResponseData()['id']);

        $this->assertNotNull($trackUploader->getObject($uploadedMultimedia->getMultimedia()));
    }

    /**
     * @depends testSuccessUpload
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUploadSubtitlesToS3(): void
    {
        $subtitlesUploader = $this->getService(SubtitlesUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'text' => $this->validData['text'],
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $uploadedMultimedia = $multimediaRepository->find($this->getApiResponseData()['id']);

        $this->assertNotNull($subtitlesUploader->getObject($uploadedMultimedia->getSubtitles()));
    }

    /**
     * @depends testSuccessUpload
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSuccessUploadImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $authorizedUser = $this->authorize($this->createArtistAccount());
        $albumId = $this->createAlbum($authorizedUser);
        $categoryId = $multimediaCategoryRepository->findByTitle($this->validData['category'])->getId();

        $this->createRequest('/api/ru/public/user/multimedia/add', 'POST', [
            'type' => $this->validData['type']->name,
            'album' => $albumId,
            'title' => $this->validData['title'],
            'description' => $this->validData['description'],
            'category' => $categoryId,
            'text' => $this->validData['text'],
            'is_obscene_words' => $this->validData['is_obscene_words'],
            'performers' => $this->validData['performers']
        ], [
            'HTTP_AUTHORIZATION' => "Bearer {$authorizedUser->getAccessToken()}"
        ], files: [
            'multimedia' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['multimedia']),
                $this->validData['multimedia']
            ),
            'subtitles' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['subtitles']),
                $this->validData['subtitles']
            ),
            'image' => new UploadedFile(
                $this->getFilePathFromFixture($this->validData['image']),
                $this->validData['image']
            )
        ]);

        $uploadedMultimedia = $multimediaRepository->find($this->getApiResponseData()['id']);

        $this->assertNotNull($imageUploader->getObject($uploadedMultimedia->getImage()));
    }

    private function changeMultimediaDurationToPlatformSetting(int $track, int $clip): void
    {
        $platformSettingRepository = $this->em()->getRepository(PlatformSetting::class);

        $platformSettingRepository
            ->getSetting(PlatformSettingEnum::MULTIMEDIA_DURATION)
            ->setValue([
                PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_TRACK_KEY->value => $track,
                PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_CLIP_KEY->value => $clip
            ]);

        $this->em()->flush();
    }
}