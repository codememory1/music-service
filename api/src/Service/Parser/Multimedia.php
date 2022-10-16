<?php

namespace App\Service\Parser;

use App\Enum\MultimediaTypeEnum;
use App\Service\Parser\Interfaces\MultimediaInterface;
use App\Service\Parser\Interfaces\MultimediaPerformerInterface;
use App\Service\Parser\Interfaces\MultimediaTimeCodeInterface;
use App\Service\Parser\Interfaces\SubtitlesInterface;

class Multimedia implements MultimediaInterface
{
    private ?MultimediaTypeEnum $type = null;
    private ?string $category = null;
    private ?string $title = null;
    private ?string $description;
    private ?string $text = null;
    private array $subtitles = [];
    private bool $isObsceneWords = false;
    private ?string $image = null;
    private ?string $producer = null;
    private array $performers = [];
    private ?string $linkToMediaFile = null;
    private array $timeCodes = [];

    public function getType(): ?MultimediaTypeEnum
    {
        return $this->type;
    }

    public function setType(MultimediaTypeEnum $type): MultimediaInterface
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): MultimediaInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): MultimediaInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): MultimediaInterface
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSubtitles(): array
    {
        return $this->subtitles;
    }

    public function addSubtitle(SubtitlesInterface $subtitle): MultimediaInterface
    {
        $this->subtitles[] = $subtitle;

        return $this;
    }

    public function isObsceneWords(): bool
    {
        return $this->isObsceneWords;
    }

    public function setIsObsceneWords(bool $isObsceneWords): MultimediaInterface
    {
        $this->isObsceneWords = $isObsceneWords;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $urlImage): MultimediaInterface
    {
        $this->image = $urlImage;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): MultimediaInterface
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPerformers(): array
    {
        return $this->performers;
    }

    public function addPerformer(MultimediaPerformerInterface $performer): MultimediaInterface
    {
        $this->performers[] = $performer;

        return $this;
    }

    public function getLinkToMediaFile(): ?string
    {
        return $this->linkToMediaFile;
    }

    public function setLinkToMediaFile(string $link): self
    {
        $this->linkToMediaFile = $link;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTimeCodes(): array
    {
        return $this->timeCodes;
    }

    public function addTimeCode(MultimediaTimeCodeInterface $timeCode): MultimediaInterface
    {
        $this->timeCodes[] = $timeCode;

        return $this;
    }
}