<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Enum\MultimediaStatusEnum;
use App\Enum\MultimediaTypeEnum;
use App\Repository\MultimediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * Class Multimedia.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaRepository::class)]
#[ORM\Table('multimedia')]
#[ORM\HasLifecycleCallbacks]
class Multimedia implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Media type from MultimediaTypeEnum'
    ])]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'multimedia')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    #[ORM\Column(type: Types::STRING, length: 50, options: [
        'comment' => 'Media name'
    ])]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 500, nullable: true, options: [
        'comment' => 'Description of media'
    ])]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, nullable: true, options: [
        'comment' => 'Path to file'
    ])]
    private ?string $multimedia = null;

    #[ORM\ManyToOne(targetEntity: MultimediaCategory::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?MultimediaCategory $category = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true, options: [
        'comment' => 'Full text of multimedia'
    ])]
    private ?array $text = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Path to subtitle file'
    ])]
    private ?string $subtitles = null;

    #[ORM\Column(type: Types::BOOLEAN, options: [
        'comment' => 'Are there obscene words in the text'
    ])]
    private bool $isObsceneWords = false;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Path to image file (preview)'
    ])]
    private ?string $image = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Multimedia producer'
    ])]
    private ?string $producer = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaPerformer::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $performers;

    #[ORM\OneToOne(mappedBy: 'multimedia', targetEntity: MultimediaMetadata::class, cascade: ['persist', 'remove'])]
    private ?MultimediaMetadata $metadata = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Media status from MultimediaStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\OneToOne(mappedBy: 'multimedia', targetEntity: MultimediaQueue::class, cascade: ['persist', 'remove'])]
    private ?MultimediaQueue $queue = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaShare::class, cascade: ['persist', 'remove'])]
    private ?Collection $shares;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaAudition::class)]
    private Collection $auditions;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaRating::class, cascade: ['persist', 'remove'])]
    private Collection $ratings;

    #[Pure]
    public function __construct()
    {
        $this->performers = new ArrayCollection();
        $this->shares = new ArrayCollection();
        $this->auditions = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param null|User $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     *
     * @return $this
     */
    public function setType(?MultimediaTypeEnum $type): self
    {
        $this->type = $type?->name;

        return $this;
    }

    /**
     * @return null|Album
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    /**
     * @param null|Album $album
     *
     * @return $this
     */
    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return $this
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMultimedia(): ?string
    {
        return $this->multimedia;
    }

    /**
     * @param null|string $multimedia
     *
     * @return $this
     */
    public function setMultimedia(?string $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    /**
     * @return null|MultimediaCategory
     */
    public function getCategory(): ?MultimediaCategory
    {
        return $this->category;
    }

    /**
     * @param null|MultimediaCategory $category
     *
     * @return $this
     */
    public function setCategory(?MultimediaCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getText(): ?array
    {
        return $this->text;
    }

    /**
     * @param null|string $text
     *
     * @return $this
     */
    public function setText(?array $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSubtitles(): ?string
    {
        return $this->subtitles;
    }

    /**
     * @param null|string $subtitles
     *
     * @return $this
     */
    public function setSubtitles(?string $subtitles): self
    {
        $this->subtitles = $subtitles;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function IsObsceneWords(): ?bool
    {
        return $this->isObsceneWords;
    }

    /**
     * @param null|bool $isObsceneWords
     *
     * @return $this
     */
    public function setIsObsceneWords(?bool $isObsceneWords): self
    {
        $this->isObsceneWords = $isObsceneWords;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     *
     * @return $this
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProducer(): ?string
    {
        return $this->producer;
    }

    /**
     * @param null|string $producer
     *
     * @return $this
     */
    public function setProducer(?string $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @return Collection<int, MultimediaPerformer>
     */
    public function getPerformers(): Collection
    {
        return $this->performers;
    }

    /**
     * @param array<MultimediaPerformer> $performers
     *
     * @return $this
     */
    public function setPerformers(array $performers): self
    {
        foreach ($performers as $performer) {
            $performer->setMultimedia($this);
        }

        $this->performers = new ArrayCollection($performers);

        return $this;
    }

    /**
     * @param MultimediaPerformer $performer
     *
     * @return $this
     */
    public function addPerformer(MultimediaPerformer $performer): self
    {
        if (!$this->performers->contains($performer)) {
            $this->performers[] = $performer;
            $performer->setMultimedia($this);
        }

        return $this;
    }

    /**
     * @param MultimediaPerformer $performer
     *
     * @return $this
     */
    public function removePerformer(MultimediaPerformer $performer): self
    {
        if ($this->performers->removeElement($performer)) {
            // set the owning side to null (unless already changed)
            if ($performer->getMultimedia() === $this) {
                $performer->setMultimedia(null);
            }
        }

        return $this;
    }

    /**
     * @return null|MultimediaMetadata
     */
    public function getMetadata(): ?MultimediaMetadata
    {
        return $this->metadata;
    }

    /**
     * @param MultimediaMetadata $metadata
     *
     * @return $this
     */
    public function setMetadata(MultimediaMetadata $metadata): self
    {
        // set the owning side of the relation if necessary
        if ($metadata->getMultimedia() !== $this) {
            $metadata->setMultimedia($this);
        }

        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param null|MultimediaStatusEnum $status
     *
     * @return $this
     */
    public function setStatus(?MultimediaStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    /**
     * @return null|MultimediaQueue
     */
    public function getQueue(): ?MultimediaQueue
    {
        return $this->queue;
    }

    /**
     * @param MultimediaQueue $queue
     *
     * @return $this
     */
    public function setQueue(MultimediaQueue $queue): self
    {
        // set the owning side of the relation if necessary
        if ($queue->getMultimedia() !== $this) {
            $queue->setMultimedia($this);
        }

        $this->queue = $queue;

        return $this;
    }

    /**
     * @return Collection<MultimediaShare>
     */
    public function getShares(): Collection
    {
        return $this->shares;
    }

    /**
     * @return Collection<int, MultimediaAudition>
     */
    public function getAuditions(): Collection
    {
        return $this->auditions;
    }

    /**
     * @param MultimediaAudition $audition
     *
     * @return $this
     */
    public function addAudition(MultimediaAudition $audition): self
    {
        if (!$this->auditions->contains($audition)) {
            $this->auditions[] = $audition;
            $audition->setMultimedia($this);
        }

        return $this;
    }

    /**
     * @param MultimediaAudition $audition
     *
     * @return $this
     */
    public function removeAudition(MultimediaAudition $audition): self
    {
        if ($this->auditions->removeElement($audition)) {
            // set the owning side to null (unless already changed)
            if ($audition->getMultimedia() === $this) {
                $audition->setMultimedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaRating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    /**
     * @param MultimediaRating $rating
     *
     * @return $this
     */
    public function addRating(MultimediaRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMultimedia($this);
        }

        return $this;
    }

    /**
     * @param MultimediaRating $rating
     *
     * @return $this
     */
    public function removeRating(MultimediaRating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getMultimedia() === $this) {
                $rating->setMultimedia(null);
            }
        }

        return $this;
    }
}