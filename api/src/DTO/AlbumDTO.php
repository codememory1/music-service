<?php

namespace App\DTO;

use App\DTO\Interceptors\AsEntityInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Album;
use App\Entity\AlbumType;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\AlbumStatusEnum;
use App\Enum\RequestTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class AlbumDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Album>
 *
 * @author  Codememory
 */
class AlbumDTO extends AbstractDTO
{
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = Album::class;

    #[Assert\NotBlank(message: 'album@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'album@maxTitleLength')]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'album@descriptionIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'album@maxDescriptionLength')]
    public ?string $description = null;

    #[Assert\NotBlank(message: 'album@imageIsRequired')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'album@maxSizeImage',
        mimeTypesMessage: 'common@uploadFileNotImage'
    )]
    public ?UploadedFile $image = null;

    #[Assert\NotBlank(message: 'album@typeIsRequired')]
    public ?AlbumType $type = null;
    public ?AlbumStatusEnum $status = null;

    #[Required]
    public ?EntityManagerInterface $em = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('title');
        $this->addExpectKey('description');
        $this->addExpectKey('type');
        $this->addExpectKey('status');

        $this->image = $this->request?->request->files->get('image');

        $this->addInterceptor('type', new AsEntityInterceptor($this->em, AlbumType::class, 'key'));
        $this->addInterceptor('status', new AsEnumInterceptor(AlbumStatusEnum::class));
        $this->callSetterToEntityWhenRequest('^admin$', 'status');
    }

    /**
     * @param ExecutionContextInterface $context
     *
     * @return void
     */
    #[Assert\Callback]
    public function callbackStatus(ExecutionContextInterface $context): void
    {
        if ($this->requestType === RequestTypeEnum::ADMIN->value && null === $this->status) {
            $context
                ->buildViolation('common@invalidStatus')
                ->atPath('status')
                ->addViolation();
        }
    }
}