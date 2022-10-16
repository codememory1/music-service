<?php

namespace App\Service\Parser\Interfaces;

use App\Enum\MultimediaTypeEnum;

interface MultimediaInterface
{
    public function getType(): ?MultimediaTypeEnum;

    public function setType(MultimediaTypeEnum $type): self;

    public function getCategory(): ?string;

    public function setCategory(string $category): self;

    public function getTitle(): ?string;

    public function setTitle(string $title): self;

    public function getDescription(): ?string;

    public function setDescription(string $description): self;

    public function getText(): ?string;

    public function setText(string $text): self;

    /**
     * @return array<int, SubtitlesInterface>
     */
    public function getSubtitles(): array;

    public function addSubtitle(SubtitlesInterface $subtitle): self;

    public function isObsceneWords(): bool;

    public function setIsObsceneWords(bool $isObsceneWords): self;

    public function getImage(): ?string;

    public function setImage(string $urlImage): self;

    public function getProducer(): ?string;

    public function setProducer(string $producer): self;

    /**
     * @return array<int, MultimediaPerformerInterface>
     */
    public function getPerformers(): array;

    public function addPerformer(MultimediaPerformerInterface $performer): self;

    public function getLinkToMediaFile(): ?string;

    /**
     * @return array<int, MultimediaTimeCodeInterface>
     */
    public function getTimeCodes(): array;

    public function addTimeCode(MultimediaTimeCodeInterface $timeCode): self;
}