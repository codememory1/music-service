<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\AlbumRepository;
use App\Trait\Entity\IdentifierTrait;
use App\Trait\Entity\TimestampTrait;
use App\Validator\Constraints as AppAssert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Album
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ORM\Table('albums')]
#[AppAssert\Authorization('common@authRequired', payload: 'not_authorized')]
#[ORM\HasLifecycleCallbacks]
class Album implements EntityInterface
{

    use IdentifierTrait;
    use TimestampTrait;

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    /**
     * @var AlbumType|null
     */
    #[ORM\ManyToOne(targetEntity: AlbumType::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlbumType $type = null;

    /**
     * @var AlbumCategory|null
     */
    #[ORM\ManyToOne(targetEntity: AlbumCategory::class, inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlbumCategory $category = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Album name'
    ])]
    private ?string $title = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, options: [
        'comment' => 'Link to album photo'
    ])]
    private ?string $photo = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::JSON, nullable: true, options: [
        'comment' => 'Album tags'
    ])]
    private ?string $tags = null;

    /**
     * @var int|null
     */
    #[ORM\Column(type: Types::INTEGER, nullable: true, options: [
        'comment' => 'Number of full plays',
        'default' => 0
    ])]
    private ?int $auditions = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @return AlbumType|null
     */
    public function getType(): ?AlbumType
    {

        return $this->type;

    }

    /**
     * @param AlbumType|null $type
     *
     * @return $this
     */
    public function setType(?AlbumType $type): self
    {

        $this->type = $type;

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
     * @param AlbumCategory|null $category
     *
     * @return $this
     */
    public function setCategory(?AlbumCategory $category): self
    {

        $this->category = $category;

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
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {

        return $this->photo;

    }

    /**
     * @param string $photo
     *
     * @return $this
     */
    public function setPhoto(string $photo): self
    {

        $this->photo = $photo;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {

        return json_decode($this->tags ?? '', true);

    }

    /**
     * @param array $tags
     *
     * @return $this
     */
    public function setTags(array $tags): self
    {

        $this->tags = json_encode($tags);

        return $this;

    }

    /**
     * @return int|null
     */
    public function getAuditions(): ?int
    {

        return $this->auditions;

    }

    /**
     * @param int $auditions
     *
     * @return $this
     */
    public function setAuditions(int $auditions): self
    {

        $this->auditions = $auditions;

        return $this;

    }

}
