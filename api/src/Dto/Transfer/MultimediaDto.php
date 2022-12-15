<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Album;
use App\Entity\Multimedia;
use App\Entity\MultimediaCategory;
use App\Entity\MultimediaPerformer;
use App\Entity\User;
use App\Enum\MultimediaTypeEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Dto\AbstractDataTransfer;
use App\Repository\LanguageCodeRepository;
use App\Security\AuthorizedUser;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManagerInterface;
use function is_string;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @template-extends AbstractDataTransfer<Multimedia>
 */
final class MultimediaDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToEnumConstraint(MultimediaTypeEnum::class)]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@typeIsRequired')
    ])]
    public ?MultimediaTypeEnum $type = null;

    #[DtoConstraints\ToEntityCallbackConstraint('callbackAlbumToEntity')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@albumIsRequired')
    ])]
    public ?Album $album = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')
    ])]
    public ?string $title = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\Length(max: 200, maxMessage: 'multimedia@descriptionMaxLength')
    ])]
    public ?string $description = null;

    #[DtoConstraints\ToEntityConstraint('id')]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@categoryIsRequired')
    ])]
    public ?MultimediaCategory $category = null;

    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@multimediaIsRequired')
    ])]
    public ?UploadedFile $multimedia = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new AppAssert\Callback('callbackValidationText')
    ])]
    public ?array $text = null;

    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\File(
            mimeTypes: ['application/x-subrip', 'text/vnd.dvb.subtitle', 'text/plain'],
            mimeTypesMessage: 'multimedia@uploadFileIsNotSubtitles'
        )
    ])]
    public ?UploadedFile $subtitles = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@isObsceneWordsIsRequired')
    ])]
    public ?bool $isObsceneWords = null;

    #[DtoConstraints\IgnoreCallSetterConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'multimedia@previewIsRequired'),
        new Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxSizeMessage: 'multimedia@maxSizePreview',
            mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
        )
    ])]
    public ?UploadedFile $image = null;

    #[DtoConstraints\ValidationConstraint([
        new Assert\Length(max: 50, maxMessage: 'multimedia@max')
    ])]
    public ?string $producer = null;

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackPerformersEntity')]
    public array $performers = [];
    private AuthorizedUser $authorizedUser;
    private LanguageCodeRepository $languageCodeRepository;

    public function __construct(ReverseContainer $container, AuthorizedUser $authorizedUser, LanguageCodeRepository $languageCodeRepository)
    {
        parent::__construct($container);

        $this->authorizedUser = $authorizedUser;
        $this->languageCodeRepository = $languageCodeRepository;
    }

    public function callbackAlbumToEntity(EntityManagerInterface $manager, mixed $value): ?Album
    {
        $albumRepository = $manager->getRepository(Album::class);

        return $albumRepository->findOneBy([
            'id' => $value,
            'user' => $this->authorizedUser->getUser()
        ]);
    }

    public function callbackPerformersEntity(EntityManagerInterface $manager, array $value): array
    {
        $userRepository = $manager->getRepository(User::class);

        foreach ($value as &$performerEmail) {
            $performer = $userRepository->findByEmail($performerEmail);

            if (null === $performer) {
                throw EntityNotFoundException::performer(['performer' => $performerEmail]);
            }

            $multimediaPerformer = new MultimediaPerformer();

            $multimediaPerformer->setUser($performer);

            $performerEmail = $multimediaPerformer;
        }

        return $value;
    }

    public function callbackValidationText(ExecutionContextInterface $context): void
    {
        $texts = $this->text ?: [];

        foreach ($texts as $code => $text) {
            if (false === is_string($code) || false === is_string($text)) {
                $context
                    ->buildViolation('multimedia@invalidText')
                    ->atPath('text')
                    ->addViolation();

                return;
            }

            if (null === $this->languageCodeRepository->findByCode($code)) {
                throw EntityNotFoundException::languageCode(['language_iso' => $code]);
            }
        }
    }
}