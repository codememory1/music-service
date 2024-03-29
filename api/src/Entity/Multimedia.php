<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Interfaces\EntityS3SettingInterface;
use App\Entity\Traits\ComparisonTrait;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UuidIdentifierTrait;
use App\Enum\EntityS3SettingEnum;
use App\Enum\MultimediaStatusEnum;
use App\Enum\MultimediaTypeEnum;
use App\Repository\MultimediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MultimediaRepository::class)]
#[ORM\Table('multimedia')]
#[ORM\HasLifecycleCallbacks]
class Multimedia implements EntityInterface, EntityS3SettingInterface
{
    use IdentifierTrait;
    use UuidIdentifierTrait;
    use TimestampTrait;
    use ComparisonTrait;

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
    private ?bool $isObsceneWords = false;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: [
        'comment' => 'Path to image file (preview)'
    ])]
    private ?string $image = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: [
        'comment' => 'Multimedia producer'
    ])]
    private ?string $producer = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaPerformer::class, cascade: ['persist', 'remove'])]
    private Collection $performers;

    #[ORM\OneToOne(mappedBy: 'multimedia', targetEntity: MultimediaMetadata::class, cascade: ['persist', 'remove'])]
    private ?MultimediaMetadata $metadata = null;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Media status from MultimediaStatusEnum'
    ])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaMediaLibrary::class, cascade: ['remove'])]
    private Collection $multimediaMediaLibrary;

    #[ORM\OneToOne(mappedBy: 'multimedia', targetEntity: MultimediaQueue::class, cascade: ['persist', 'remove'])]
    private ?MultimediaQueue $queue = null;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaShare::class, cascade: ['persist', 'remove'])]
    private Collection $shares;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaAudition::class)]
    private Collection $auditions;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaRating::class, cascade: ['persist', 'remove'])]
    private Collection $ratings;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: RunningMultimedia::class, cascade: ['persist', 'remove'])]
    private Collection $runningMultimedia;

    #[ORM\OneToMany(mappedBy: 'multimedia', targetEntity: MultimediaTimeCode::class, cascade: ['persist', 'remove'])]
    private Collection $timeCodes;

    #[ORM\OneToOne(mappedBy: 'multimedia', targetEntity: MultimediaStatistic::class, cascade: ['persist', 'remove'])]
    private ?MultimediaStatistic $statistic = null;

    public function __construct()
    {
        $this->generateUuid();

        $this->performers = new ArrayCollection();
        $this->shares = new ArrayCollection();
        $this->auditions = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->runningMultimedia = new ArrayCollection();
        $this->timeCodes = new ArrayCollection();
    }

    public function getFolderName(): EntityS3SettingEnum
    {
        return EntityS3SettingEnum::MULTIMEDIA;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?MultimediaTypeEnum $type): self
    {
        $this->type = $type?->name;

        return $this;
    }

    public function setTrackType(): self
    {
        $this->setType(MultimediaTypeEnum::TRACK);

        return $this;
    }

    public function isTrack(): bool
    {
        return $this->getType() === MultimediaTypeEnum::TRACK->name;
    }

    public function setClipType(): self
    {
        $this->setType(MultimediaTypeEnum::CLIP);

        return $this;
    }

    public function isClip(): bool
    {
        return $this->getType() === MultimediaTypeEnum::CLIP->name;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMultimedia(): ?string
    {
        return $this->multimedia;
    }

    public function setMultimedia(?string $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    public function getCategory(): ?MultimediaCategory
    {
        return $this->category;
    }

    public function setCategory(?MultimediaCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getText(): ?array
    {
        return $this->text;
    }

    public function setText(?array $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSubtitles(): ?string
    {
        return $this->subtitles;
    }

    public function setSubtitles(?string $subtitles): self
    {
        $this->subtitles = $subtitles;

        return $this;
    }

    public function isObsceneWords(): ?bool
    {
        return $this->isObsceneWords;
    }

    public function setIsObsceneWords(?bool $isObsceneWords): self
    {
        $this->isObsceneWords = $isObsceneWords;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

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

    public function getEmailPerformers(): array
    {
        return $this->getPerformers()->map(static fn(MultimediaPerformer $multimediaPerformer) => $multimediaPerformer->getUser()->getEmail())->toArray();
    }

    /**
     * @param array<MultimediaPerformer> $performers
     */
    public function setPerformers(array $performers): self
    {
        foreach ($performers as $performer) {
            $performer->setMultimedia($this);
        }

        $this->performers = new ArrayCollection($performers);

        return $this;
    }

    public function addPerformer(MultimediaPerformer $performer): self
    {
        if (!$this->performers->contains($performer)) {
            $this->performers[] = $performer;
            $performer->setMultimedia($this);
        }

        return $this;
    }

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

    public function getMetadata(): ?MultimediaMetadata
    {
        return $this->metadata;
    }

    public function setMetadata(MultimediaMetadata $metadata): self
    {
        // set the owning side of the relation if necessary
        if ($metadata->getMultimedia() !== $this) {
            $metadata->setMultimedia($this);
        }

        $this->metadata = $metadata;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?MultimediaStatusEnum $status): self
    {
        $this->status = $status?->name;

        return $this;
    }

    public function setDraftStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::DRAFT);

        return $this;
    }

    public function isDraft(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::DRAFT->name;
    }

    public function setModerationStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::MODERATION);

        return $this;
    }

    public function isModeration(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::MODERATION->name;
    }

    public function setPublishStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::PUBLISHED);

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::PUBLISHED->name;
    }

    public function setUnpublishStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::UNPUBLISHED);

        return $this;
    }

    public function isUnpublished(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::UNPUBLISHED->name;
    }

    public function setAppealStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::APPEAL);

        return $this;
    }

    public function isAppeal(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::APPEAL->name;
    }

    public function setAppealCanceledStatus(): self
    {
        $this->setStatus(MultimediaStatusEnum::APPEAL_CANCELED);

        return $this;
    }

    public function isAppealCanceled(): bool
    {
        return $this->getStatus() === MultimediaStatusEnum::APPEAL_CANCELED->name;
    }

    public function getMultimediaMediaLibrary(): Collection
    {
        return $this->multimediaMediaLibrary;
    }

    public function getQueue(): ?MultimediaQueue
    {
        return $this->queue;
    }

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
     * @return Collection<int, MultimediaShare>
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

    public function addAudition(MultimediaAudition $audition): self
    {
        if (!$this->auditions->contains($audition)) {
            $this->auditions[] = $audition;
            $audition->setMultimedia($this);
        }

        return $this;
    }

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

    public function addRating(MultimediaRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setMultimedia($this);
        }

        return $this;
    }

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

    /**
     * @return Collection<int, RunningMultimedia>
     */
    public function getRunningMultimedia(): Collection
    {
        return $this->runningMultimedia;
    }

    public function addRunningMultimedia(RunningMultimedia $runningMultimedia): self
    {
        if (!$this->runningMultimedia->contains($runningMultimedia)) {
            $this->runningMultimedia[] = $runningMultimedia;
            $runningMultimedia->setMultimedia($this);
        }

        return $this;
    }

    public function removeRunningMultimedia(RunningMultimedia $runningMultimedia): self
    {
        if ($this->runningMultimedia->removeElement($runningMultimedia)) {
            // set the owning side to null (unless already changed)
            if ($runningMultimedia->getMultimedia() === $this) {
                $runningMultimedia->setMultimedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MultimediaTimeCode>
     */
    public function getTimeCodes(): Collection
    {
        return $this->timeCodes;
    }

    public function addTimeCode(MultimediaTimeCode $timeCode): self
    {
        if (!$this->timeCodes->contains($timeCode)) {
            $this->timeCodes[] = $timeCode;
            $timeCode->setMultimedia($this);
        }

        return $this;
    }

    public function removeTimeCode(MultimediaTimeCode $timeCode): self
    {
        if ($this->timeCodes->removeElement($timeCode)) {
            // set the owning side to null (unless already changed)
            if ($timeCode->getMultimedia() === $this) {
                $timeCode->setMultimedia(null);
            }
        }

        return $this;
    }

    public function getStatistic(): ?MultimediaStatistic
    {
        return $this->statistic;
    }

    public function setStatistic(MultimediaStatistic $statistic): self
    {
        // set the owning side of the relation if necessary
        if ($statistic->getMultimedia() !== $this) {
            $statistic->setMultimedia($this);
        }

        $this->statistic = $statistic;

        return $this;
    }
}