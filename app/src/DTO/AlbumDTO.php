<?php

namespace App\DTO;

use App\Entity\Album;
use App\Entity\AlbumCategory;
use App\Entity\AlbumType;
use App\Service\RequestDataService;
use App\Validator\Constraints as AppAssert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumDTO extends AbstractDTO
{

    /**
     * @var array
     */
    protected array $requestKeys = [
        'title', 'type', 'category', 'tags'
    ];

    /**
     * @var string|null
     */
    protected ?string $entityClass = Album::class;

    /**
     * @var array
     */
    protected array $valueAsEntity = [
        'type'     => [AlbumType::class, 'id'],
        'category' => [AlbumCategory::class, 'id'],
    ];

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'album@titleIsRequired', payload: 'title_is_required')]
    #[Assert\Length(max: 255, maxMessage: 'album@titleMaxLength', payload: 'title_length')]
    private ?string $title = null;

    /**
     * @var AlbumType|null
     */
    #[Assert\NotBlank(
        message: 'album@typeNotExistOrNotEntered',
        payload: 'type_not_exist_or_not_entered'
    )]
    private ?AlbumType $type = null;

    /**
     * @var AlbumCategory|null
     */
    #[Assert\NotBlank(
        message: 'album@categoryNotExistOrNotEntered',
        payload: 'category_not_exist_or_not_entered'
    )]
    private ?AlbumCategory $category = null;

    /**
     * @var File|null
     */
    #[Assert\NotBlank(message: 'album@photoIsRequired', payload: 'photo_is_required')]
    #[Assert\File(
        maxSize: '1024k',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'album@photoMaxSize',
        mimeTypesMessage: 'album@photoMimeTypes',
        payload: 'photo_error'
    )]
    private ?File $photo = null;

    /**
     * @var string|null
     */
    #[Assert\NotBlank(message: 'album@tagsIsRequired', payload: 'tags_is_required')]
    #[AppAssert\QuantityByDelimiter(
        ',',
        max: 255,
        maxMessage: 'album@maxTags',
        payload: 'number_of_tags'
    )]
    private ?string $tags = null;

    /**
     * @param string|null $title
     *
     * @return AlbumDTO
     */
    public function setTitle(?string $title): self
    {

        $this->title = $title;

        return $this;

    }
    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {

        return $this->title;

    }
    /**
     * @param AlbumType|null $type
     *
     * @return AlbumDTO
     */
    public function setType(?AlbumType $type): self
    {

        $this->type = $type;

        return $this;

    }
    /**
     * @return AlbumType|null
     */
    public function getType(): ?AlbumType
    {

        return $this->type;

    }
    /**
     * @param AlbumCategory|null $category
     *
     * @return AlbumDTO
     */
    public function setCategory(?AlbumCategory $category): self
    {

        $this->category = $category;

        return $this;

    }
    /**
     * @return AlbumCategory|null
     */
    public function getCategory(): ?AlbumCategory
    {

        return $this->category;

    }
    /**
     * @param File|null $photo
     *
     * @return AlbumDTO
     */
    public function setPhoto(?File $photo): self
    {

        $this->photo = $photo;

        return $this;

    }
    /**
     * @return File|null
     */
    public function getPhoto(): ?File
    {

        return $this->photo;

    }
    /**
     * @param string|null $tags
     *
     * @return AlbumDTO
     */
    public function setTags(?string $tags): self
    {

        $this->tags = $tags;

        return $this;

    }
    /**
     * @return array
     */
    public function getTags(): array
    {

        $tags = explode(',', $this->tags);

        return array_map(function(string|int $value) {

            return trim($value);
        }, $tags);

    }

}