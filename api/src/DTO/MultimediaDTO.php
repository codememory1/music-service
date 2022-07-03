<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsBooleanInterceptor;
use App\DTO\Interceptors\AsEntityInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Album;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Multimedia;
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
 * @template-extends AbstractDTO<Multimedia>
 *
 * @author  Codememory
 */
class MultimediaDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = Multimedia::class;

    #[Assert\NotBlank(message: 'multimedia@typeIsRequired')]
    public ?MultimediaTypeEnum $type = null;

    #[Assert\NotBlank(message: 'multimedia@albumIsRequired')]
    public ?Album $album = null;

    #[Assert\NotBlank(message: 'multimedia@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')]
    public ?string $title = null;

    #[Assert\Length(max: 200, maxMessage: 'multimedia@descriptionMaxLength')]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'multimedia@multimediaIsRequired')]
    public ?UploadedFile $multimedia = null;

    #[Assert\NotBlank(message: 'multimedia@categoryIsRequired')]
    public ?MultimediaCategory $category = null;
    public ?array $text = null;

    #[Assert\File(
        mimeTypes: ['application/x-subrip', 'text/vnd.dvb.subtitle', 'text/plain'],
        mimeTypesMessage: 'multimedia@uploadFileIsNotSubtitles'
    )]
    public ?UploadedFile $subtitles = null;

    #[Assert\NotBlank(message: 'multimedia@isObsceneWordsIsRequired')]
    public ?bool $isObsceneWords = null;

    #[Assert\NotBlank(message: 'multimedia@previewIsRequired')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'multimedia@maxSizePreview',
        mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
    )]
    public ?UploadedFile $image = null;
    public array $performers = [];

    #[Required]
    public ?EntityManagerInterface $em = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('type');
        $this->addExpectKey('album');
        $this->addExpectKey('title');
        $this->addExpectKey('description');
        $this->addExpectKey('category');
        $this->addExpectKey('text');
        $this->addExpectKey('is_obscene_words', 'isObsceneWords');
        $this->addExpectKey('producer');
        $this->addExpectKey('performers');

        $this->preventSetterCallForKeys(['performers']);

        $this->image = $this->request?->request->files->get('image');
        $this->multimedia = $this->request?->request->files->get('multimedia');
        $this->subtitles = $this->request?->request->files->get('subtitles');

        $this->addInterceptor('type', new AsEnumInterceptor(MultimediaTypeEnum::class));
        $this->addInterceptor('album', new AsEntityInterceptor($this->em, Album::class, 'id', [
            'user' => $this->authorizedUser->getUser()
        ]));
        $this->addInterceptor('category', new AsEntityInterceptor($this->em, MultimediaCategory::class, 'id'));
        $this->addInterceptor('text', new AsArrayInterceptor());
        $this->addInterceptor('isObsceneWords', new AsBooleanInterceptor());
        $this->addInterceptor('performers', new AsArrayInterceptor());
    }
}