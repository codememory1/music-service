<?php

namespace App\Service\Parser\Repository;

use App\Enum\MultimediaTypeEnum;
use App\Service\Parser\Interfaces\MultimediaPerformerInterface;
use App\Service\Parser\Interfaces\MultimediaTimeCodeInterface;
use App\Service\Parser\Interfaces\SubtitlesInterface;

class Multimedia
{
    private ?MultimediaTypeEnum $type = null;
    private ?int $number = null;
    private array $categories = [];
    private ?string $name = null;
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

    public function setType(MultimediaTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(MultimediaCategory $category): self
    {
        $this->categories[] = $category;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getSubtitles(): array
    {
        return $this->subtitles;
    }

    public function addSubtitle(SubtitlesInterface $subtitle): self
    {
        $this->subtitles[] = $subtitle;

        return $this;
    }

    public function isObsceneWords(): bool
    {
        return $this->isObsceneWords;
    }

    public function setIsObsceneWords(bool $isObsceneWords): self
    {
        $this->isObsceneWords = $isObsceneWords;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $urlImage): self
    {
        $this->image = $urlImage;

        return $this;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    public function getPerformers(): array
    {
        return $this->performers;
    }

    public function addPerformer(MultimediaPerformerInterface $performer): self
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

    public function getTimeCodes(): array
    {
        return $this->timeCodes;
    }

    public function addTimeCode(MultimediaTimeCodeInterface $timeCode): self
    {
        $this->timeCodes[] = $timeCode;

        return $this;
    }
}