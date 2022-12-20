<?php

namespace App\Tests\Application\PublicAvailable\Album\Create;

use App\Entity\Album;
use App\Enum\AlbumTypeEnum;
use App\Enum\ResponseTypeEnum;
use App\Rest\S3\Uploader\ImageUploader;
use App\Tests\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

final class CreateTest extends AbstractApiTestCase
{
    public const API_PATH = '/api/ru/public/album/create';
    private array $validateData = [
        'type' => AlbumTypeEnum::SINGLE,
        'title' => 'Battle grounds',
        'description' => 'Description for battle grounds album',
        'image' => 'image_1.3mb.jpg'
    ];

    protected function setUp(): void
    {
        $this->browser->createRequest(self::API_PATH);
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->setBearerAuth($this->authorize('artist@gmail.com'));
        $this->browser->prepareRequestData('type', $this->validateData['type']->name);
        $this->browser->prepareRequestData('title', $this->validateData['title']);
        $this->browser->prepareRequestData('description', $this->validateData['description']);
    }

    public function testTypeIsRequired(): void
    {
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTypeNotExist(): void
    {
        $this->browser->addRequestData('type', 'InvalidType');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@typeIsRequired');
    }

    public function testTitleIsRequired(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@titleIsRequired');
    }

    public function testTitleMaxLength(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->addRequestData('title', 'PEhssogFEJDvDKFsuyQytFFcvrpEFPWVHddAdemmWTbkNMpjSkMjjbk');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxTitleLength');
    }

    public function testDescriptionIsRequired(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@descriptionIsRequired');
    }

    public function testDescriptionMaxLength(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->addRequestData('description', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxDescriptionLength');
    }

    public function testImageIsRequired(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@imageIsRequired');
    }

    public function testAllowedMimeTypeImage(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addFile('image', $this->getFilePathFromFixture('text_2.5mb.txt'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@uploadFileNotImage');
    }

    public function testMaxSizeImage(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addFile('image', $this->getFilePathFromFixture('image_18mb.png'));
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('album@maxSizeImage');
    }

    public function testOnlyOneImage(): void
    {
        $this->browser->usePreparedRequestData('type');
        $this->browser->usePreparedRequestData('title');
        $this->browser->usePreparedRequestData('description');
        $this->browser->addMultipleFile(
            'image',
            $this->getFilePathFromFixture('image_1.3mb.jpg'),
            $this->getFilePathFromFixture('image_2mb.png')
        );
        $this->browser->sendRequest();

        $this->assertApiStatusCode(422);
        $this->assertApiType(ResponseTypeEnum::INPUT_VALIDATION);
        $this->assertApiMessage('common@onlyOneImage');
    }

    public function testSuccessCreate(): void
    {
        $this->successCreateAlbum();

        $this->assertApiStatusCode(200);
        $this->assertApiType(ResponseTypeEnum::CREATE);
        $this->assertApiMessage('Альбом успешно создан');
        $this->assertArrayHasKey('id', $this->browser->getResponseData());
        $this->assertIsInt($this->browser->getResponseData('id'));
    }

    /**
     * @depends testSuccessCreate
     */
    public function testSuccessFlushToDb(): void
    {
        $this->successCreateAlbum();

        $albumRepository = $this->em()->getRepository(Album::class);
        $album = $albumRepository->find($this->browser->getResponseData('id'));

        $this->assertNotNull($album);
        $this->assertEquals($this->validateData['type']->name, $album->getType()->getKey());
        $this->assertEquals($this->validateData['title'], $album->getTitle());
        $this->assertEquals($this->validateData['description'], $album->getDescription());
        $this->assertNotNull($album->getImage());
    }

    /**
     * @depends testSuccessFlushToDb
     */
    public function testSuccessSaveImageToS3(): void
    {
        $this->successCreateAlbum();

        $imageUploader = $this->getService(ImageUploader::class);
        $albumRepository = $this->em()->getRepository(Album::class);
        $album = $albumRepository->find($this->browser->getResponseData('id'));

        $this->assertNotNull($imageUploader->getObject($album->getImage()));
    }

    private function successCreateAlbum(): void
    {
        $this->browser->addRequestData('type', $this->validateData['type']->name);
        $this->browser->addRequestData('title', $this->validateData['title']);
        $this->browser->addRequestData('description', $this->validateData['description']);
        $this->browser->addFile('image', $this->getFilePathFromFixture($this->validateData['image']));
        $this->browser->sendRequest();
    }
}