<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\Album;
use App\Entity\Multimedia;
use App\Entity\MultimediaCategory;
use App\Entity\MultimediaPerformer;
use App\Entity\User;
use App\Enum\MultimediaTypeEnum;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Security\AuthorizedUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ReverseContainer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MultimediaDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<Multimedia>
 *
 * @author  Codememory
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

    #[Assert\NotBlank(message: 'multimedia@multimediaIsRequired')]
    #[DtoConstraints\IgnoreCallSetterConstraint]
    public ?UploadedFile $multimedia = null;

    #[Assert\NotBlank(message: 'multimedia@categoryIsRequired')]
    #[DtoConstraints\ToEntityConstraint('id')]
    public ?MultimediaCategory $category = null;

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

    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ToEntityCallbackConstraint('callbackPerformersEntity')]
    public array $performers = [];
    private AuthorizedUser $authorizedUser;

    public function __construct(ReverseContainer $container, AuthorizedUser $authorizedUser)
    {
        parent::__construct($container);

        $this->authorizedUser = $authorizedUser;
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
}