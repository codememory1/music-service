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
use App\Repository\MultimediaRepository;
use App\Rest\S3\Uploader\ClipUploader;
use App\Rest\S3\Uploader\ImageUploader;
use App\Rest\S3\Uploader\SubtitlesUploader;
use App\Rest\S3\Uploader\TrackUploader;
use App\Tests\AbstractApiTestCase;
use App\Tests\Traits\MultimediaTrait;
use App\Tests\Traits\SecurityTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class UploadMultimediaTest extends AbstractApiTestCase
{
    use SecurityTrait;
    use MultimediaTrait;
    public const API_PATH = '/api/ru/public/user/multimedia/add';
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
    private ?MultimediaRepository $multimediaRepository = null;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function setUp(): void
    {
        $multimediaCategoryRepository = $this->em()->getRepository(MultimediaCategory::class);
        $multimediaRepository = $this->em()->getRepository(Multimedia::class);
        $multimediaCategory = $multimediaCategoryRepository->findByTitle($this->validData['category']);
        $authorizedUserSession = $this->authorize($this->createArtistAccount());
        $albumOwnerSession = $this->authorize($this->createArtistAccount('owner-album@gmail.com'));
        $album = $this->createAlbum($authorizedUserSession);
        $albumNotBelongToAuthorizedUser = $this->createAlbum($albumOwnerSession);

        $this->multimediaRepository = $multimediaRepository;

        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->prepareBearerAuth($authorizedUserSession);
        $this->browser->prepareRequestData('type', $this->validData['type']->name);
        $this->browser->prepareRequestData('album', $album->getId());
        $this->browser->prepareRequestData('title', $this->validData['title']);
        $this->browser->prepareRequestData('description', $this->validData['description']);
        $this->browser->prepareRequestData('category', $multimediaCategory->getId());
        $this->browser->prepareRequestData('text', $this->validData['text']);
        $this->browser->prepareRequestData('is_obscene_words', $this->validData['is_obscene_words']);
        $this->browser->prepareRequestData('producer', $this->validData['producer']);
        $this->browser->prepareRequestData('performers', $this->validData['performers']);
        $this->browser->addReference('notMyAlbum', $albumNotBelongToAuthorizedUser->getId());
    }

    public function testAuthorizeIsRequired(): void
    {
        $this->browser->sendRequest();

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
        $authorizedUserSession = $this->authorize('user@gmail.com');

        $this->browser->setBearerAuth($authorizedUserSession);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(403);
        $this->assertApiType(ResponseTypeEnum::CHECK_ACCESS);
        $this->assertApiMessage('accessDenied@notSubscriptionPermissions');
    }

    public function testTypeIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@typeIsRequired');
    }

    public function testTypeNotExist(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->addRequestData('type', 'InvalidType');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@typeIsRequired');
    }

    public function testAlbumIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData('type');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
    }

    public function testAlbumNotExist(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData('type');
        $this->browser->addRequestData('album', 0);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
    }

    public function testAlbumNotBelongToMe(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type']);
        $this->browser->addRequestData('album', $this->browser->getReference('notMyAlbum'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@albumIsRequired');
    }

    public function testTitleIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@titleIsRequired');
    }

    public function testTitleMaxLength(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album']);
        $this->browser->addRequestData('title', 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@titleMaxLength');
    }

    public function tesDescriptionMaxLength(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title']);
        $this->browser->addRequestData('description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@descriptionMaxLength');
    }

    public function testCategoryIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@categoryIsRequired');
    }

    public function testCategoryNotExist(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description']);
        $this->browser->addRequestData('category', 0);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@categoryIsRequired');
    }

    public function testInvalidText(): void
    {
        // TODO: validate text multimedia by schema
    }

    public function testMultimediaIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text']);
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@multimediaIsRequired');
    }

    public function testInvalidMimeTypeSubtitles(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture('image_1.3mb.jpeg'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@uploadFileIsNotSubtitles');
    }

    public function testIsObsceneWordsIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'text', 'category']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@isObsceneWordsIsRequired');
    }

    public function testImageIsRequired(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@previewIsRequired');
    }

    public function testInvalidMimeTypeImage(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture('text_2.5mb.txt'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@uploadFileIsNotPreview');
    }

    public function testMaxSizeImage(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture('image_17.8mb.jpeg'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('multimedia@maxSizePreview');
    }

    public function testPerformerNotExist(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words']);
        $this->browser->addRequestData('performers', ['invalid-performer@gmail.com']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(404);
        $this->assertApiType(ResponseTypeEnum::NOT_EXIST);
        $this->assertApiMessage('entityNotFound@performer');
    }

    public function testInvalidMimeTypeTrack(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture('video_544kb_00-31time.mp4'));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('multimedia@invalidTrackMimeType');
    }

    public function testInvalidMimeTypeClip(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addRequestData('type', MultimediaTypeEnum::CLIP->name);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture('music_5.8mb_02-23time.mp3'));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('multimedia@invalidClipMimeType');
    }

    public function testInvalidSubtitles(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture('subtitles_182B_not_valid.srt'));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::CHECK_VALID);
        $this->assertApiMessage('common@invalidSubtitles');
    }

    public function testInvalidDurationToClip(): void
    {
        $this->changeMultimediaDurationToPlatformSetting(120, 60);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addRequestData('type', MultimediaTypeEnum::CLIP->name);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture('video_50.2mb_01-32time.mp4'));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('multimedia@badDuration');
    }

    public function testInvalidDurationToTrack(): void
    {
        $this->changeMultimediaDurationToPlatformSetting(120, 60);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture('music_5.8mb_02-23time.wav'));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(400);
        $this->assertApiType(ResponseTypeEnum::FAILED);
        $this->assertApiMessage('multimedia@badDuration');
    }

    public function testSuccessUpload(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::CREATE);
        $this->assertApiMessage('Мультимедия успешно добавлена и ожидает отправки на модерацию');
        $this->assertOnlyArrayHasKey('id', $this->browser->getResponseData());
        $this->assertIsInt($this->browser->getResponseData('id'));
    }

    /**
     * @depends testSuccessUpload
     */
    public function testSuccessFlushToDb(): void
    {
        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $uploadedMultimedia = $this->multimediaRepository->find($this->browser->getResponseData('id'));

        $this->assertEquals($this->browser->getPreparedRequestData('type'), $uploadedMultimedia->getType());
        $this->assertEquals($this->browser->getPreparedRequestData('album'), $uploadedMultimedia->getAlbum()->getId());
        $this->assertEquals($this->browser->getPreparedRequestData('title'), $uploadedMultimedia->getTitle());
        $this->assertEquals($this->browser->getPreparedRequestData('description'), $uploadedMultimedia->getDescription());
        $this->assertEquals($this->browser->getPreparedRequestData('category'), $uploadedMultimedia->getCategory()->getId());
        $this->assertEquals($this->browser->getPreparedRequestData('text'), $uploadedMultimedia->getText());
        $this->assertEquals($this->browser->getPreparedRequestData('is_obscene_words'), $uploadedMultimedia->isObsceneWords());
        $this->assertEquals($this->browser->getPreparedRequestData('performers'), $uploadedMultimedia->getEmailPerformers());
        $this->assertNotNull($uploadedMultimedia->getMultimedia());
        $this->assertNotNull($uploadedMultimedia->getSubtitles());
        $this->assertNotNull($uploadedMultimedia->getImage());
        $this->assertEquals(MultimediaStatusEnum::DRAFT->name, $uploadedMultimedia->getStatus());
        $this->assertNull($uploadedMultimedia->getQueue());
    }

    /**
     * @depends testSuccessUpload
     */
    public function testSuccessUploadClipToS3(): void
    {
        $clipUploader = $this->getService(ClipUploader::class);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addRequestData('type', MultimediaTypeEnum::CLIP->name);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture('video_544kb_00-31time.mp4'));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $uploadedMultimedia = $this->multimediaRepository->find($this->browser->getResponseData('id'));

        $this->assertNotNull($clipUploader->getObject($uploadedMultimedia->getMultimedia()));
    }

    /**
     * @depends testSuccessUpload
     */
    public function testSuccessUploaderTrackToS3(): void
    {
        $trackUploader = $this->getService(TrackUploader::class);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $uploadedMultimedia = $this->multimediaRepository->find($this->browser->getResponseData('id'));

        $this->assertNotNull($trackUploader->getObject($uploadedMultimedia->getMultimedia()));
    }

    /**
     * @depends testSuccessUpload
     */
    public function testSuccessUploadSubtitlesToS3(): void
    {
        $subtitlesUploader = $this->getService(SubtitlesUploader::class);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $uploadedMultimedia = $this->multimediaRepository->find($this->browser->getResponseData('id'));

        $this->assertNotNull($subtitlesUploader->getObject($uploadedMultimedia->getSubtitles()));
    }

    /**
     * @depends testSuccessUpload
     */
    public function testSuccessUploadImageToS3(): void
    {
        $imageUploader = $this->getService(ImageUploader::class);

        $this->browser->usePreparedBearerAuth();
        $this->browser->usePreparedRequestData(['type', 'album', 'title', 'description', 'category', 'text', 'is_obscene_words', 'performers']);
        $this->browser->addFile('multimedia', $this->getFilePathFromFixture($this->validData['multimedia']));
        $this->browser->addFile('subtitles', $this->getFilePathFromFixture($this->validData['subtitles']));
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validData['image']));
        $this->browser->sendRequest();

        $uploadedMultimedia = $this->multimediaRepository->find($this->browser->getResponseData('id'));

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