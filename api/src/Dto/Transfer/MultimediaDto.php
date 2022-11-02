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
use App\Infrastucture\Dto\AbstractDataTransfer;
use App\Repository\LanguageCodeRepository;
use App\Security\AuthorizedUser;
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
    #[Assert\NotBlank(message: 'multimedia@typeIsRequired')]
    #[DtoConstraints\ToEnumConstraint(MultimediaTypeEnum::class)]
    public ?MultimediaTypeEnum $type = null;

    #[Assert\NotBlank(message: 'multimedia@albumIsRequired')]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackAlbumToEntity')]
    public ?Album $album = null;

    #[Assert\NotBlank(message: 'multimedia@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'multimedia@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;

    #[Assert\Length(max: 200, maxMessage: 'multimedia@descriptionMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'multimedia@categoryIsRequired')]
    #[DtoConstraints\ToEntityConstraint('id')]
    public ?MultimediaCategory $category = null;

    #[Assert\NotBlank(message: 'multimedia@multimediaIsRequired')]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $multimedia = null;

    #[DtoConstraints\ToTypeConstraint]
    public ?array $text = null;

    #[Assert\File(
        mimeTypes: ['application/x-subrip', 'text/vnd.dvb.subtitle', 'text/plain'],
        mimeTypesMessage: 'multimedia@uploadFileIsNotSubtitles'
    )]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $subtitles = null;

    #[Assert\NotBlank(message: 'multimedia@isObsceneWordsIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?bool $isObsceneWords = null;

    #[Assert\NotBlank(message: 'multimedia@previewIsRequired')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'multimedia@maxSizePreview',
        mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
    )]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $image = null;

    #[Assert\Length(max: 50, maxMessage: 'multimedia@max')]
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
                throw EntityNotFoundException::performer($performerEmail);
            }

            $multimediaPerformer = new MultimediaPerformer();

            $multimediaPerformer->setUser($performer);

            $performerEmail = $multimediaPerformer;
        }

        return $value;
    }

    #[Assert\Callback]
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
                throw EntityNotFoundException::languageCode($code);
            }
        }
    }
}