<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsBooleanInterceptor;
use App\DTO\Interceptors\AsEntityInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Album;
use App\Entity\MultimediaCategory;
use App\Enum\MultimediaTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class MultimediaDTO.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class MultimediaDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'multimedia@typeIsRequired')]
    public ?MultimediaTypeEnum $type = null;

    #[Assert\NotBlank(message: 'multimedia@albumIsRequired')]
    public ?Album $album = null;

    #[Assert\NotBlank(message: 'multimedia@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')]
    public ?string $title = null;

    #[Assert\Length(max: 200, maxMessage: 'multimedia@descriptionMaxLength')]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'multimedia@categoryIsRequired')]
    public ?string $category = null;

    /**
     * @var null|string
     */
    public ?string $fullText = null;

    /**
     * @var null|UploadedFile
     */
    public ?UploadedFile $subtitles = null;

    #[Assert\NotBlank(message: 'multimedia@isObsceneWordsIsRequired')]
    public ?bool $isObsceneWords = null;

    #[Assert\NotBlank(message: 'multimedia@imageIsRequired')]
    public ?UploadedFile $image = null;

    /**
     * @var array
     */
    public array $performers = [];

    #[Required]
    public ?EntityManagerInterface $em = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('type');
        $this->addExpectKey('album');
        $this->addExpectKey('title');
        $this->addExpectKey('description');
        $this->addExpectKey('category');
        $this->addExpectKey('full_text', 'fullText');
        $this->addExpectKey('subtitles');
        $this->addExpectKey('is_obscene_words', 'isObsceneWords');
        $this->addExpectKey('image');
        $this->addExpectKey('performers');

        $this->addInterceptor('type', new AsEnumInterceptor(MultimediaTypeEnum::class));
        $this->addInterceptor('album', new AsEntityInterceptor($this->em, Album::class, 'id', [
            'user' => $this->authorizedUser->getUser()
        ]));
        $this->addInterceptor('category', new AsEntityInterceptor($this->em, MultimediaCategory::class, 'id'));
        $this->addInterceptor('fullText', new AsArrayInterceptor());
        $this->addInterceptor('isObsceneWords', new AsBooleanInterceptor());
        $this->addInterceptor('performers', new AsArrayInterceptor());
    }
}