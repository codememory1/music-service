<?php

namespace App\DTO;

use App\DTO\Interceptor\AlbumInputCategoryInterceptor;
use App\DTO\Interceptor\AlbumInputTagsInterceptor;
use App\DTO\Interceptor\AlbumInputTypeInterceptor;
use App\Entity\Album;
use App\Entity\AlbumCategory;
use App\Entity\AlbumType;
use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use ReflectionException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class AlbumDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'album@titleIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'album@titleMaxLength')]
    public ?string $title = null;

    /**
     * @var null|AlbumType
     */
    #[Assert\NotBlank(
        message: 'album@typeNotExistOrNotEntered',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?AlbumType $type = null;

    /**
     * @var null|AlbumCategory
     */
    #[Assert\NotBlank(
        message: 'album@categoryNotExistOrNotEntered',
        payload: ApiResponseTypeEnum::CHECK_EXIST
    )]
    public ?AlbumCategory $category = null;

    /**
     * @var null|UploadedFile
     */
    #[Assert\NotBlank(message: 'album@photoIsRequired')]
    #[Assert\File(
        maxSize: '1024k',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'album@photoMaxSize',
        mimeTypesMessage: 'album@photoMimeTypes'
    )]
    public ?UploadedFile $photo = null;

    /**
     * @var array
     */
    #[Assert\NotBlank(message: 'album@tagsIsRequired')]
    #[AppAssert\ArrayValues(max: 255, maxMessage: 'album@maxTags')]
    public array $tags = [];

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     * @throws ClassNotFoundException
     */
    protected function wrapper(): void
    {
        $this->setEntity(Album::class);

        $this
            ->addExpectedRequestKey('title')
            ->addExpectedRequestKey('type')
            ->addExpectedRequestKey('category')
            ->addExpectedRequestKey('tags');

        $this
            ->addInterceptor('type', AlbumInputTypeInterceptor::class)
            ->addInterceptor('category', AlbumInputCategoryInterceptor::class)
            ->addInterceptor('tags', AlbumInputTagsInterceptor::class);

        $this->photo = $this->request->request->files->get('photo');
    }

    /**
     * @param Album|EntityInterface $entity
     * @param array                 $excludeKeys
     *
     * @return array
     */
    public function toArray(EntityInterface $entity, array $excludeKeys = []): array
    {
        return $this->toArrayHandler([
            'id' => $entity->getId(),
            'title' => $entity->getTitle(),
            'type' => [
                'key' => $entity->getType()->getKey(),
                'title' => $entity->getType()->getTitleTranslationKey()
            ],
            'category' => [
                'title' => $entity->getCategory()->getTitleTranslationKey()
            ],
            'tags' => $entity->getTags(),
            'created_at' => $entity->getCreatedAt()->format('Y-m-d H:i'),
            'updated_at' => $entity->getUpdatedAt()?->format('Y-m-d H:i')
        ]);
    }
}